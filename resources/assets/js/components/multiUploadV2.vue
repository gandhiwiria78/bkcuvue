<template>
<!-- Dokumentasi 
    - cara kerja komponen ini, mengupload segala file dengan batas 5 file dengan drag atau pilih file, dan memunculkan file ke kotak dibawah dropzone
      apabila user maka menekan tanda x pada itemfile . maka file akan terhapus.
    - kelemahan apabila file tidak jadi diupload , atau refresh page maka file sudah ada di folder website.
    - maka dari itu perlu file manager yang perlu menghandle semua file.
    seperti di wordpress.

    - Komponen ini menggunakan vuex sebagai penghubung ke parent nya
      dan controller untuk penghubung ke database untuk menyimpan id_file, nama, path, jenis, created,updated

    - membutuhkan setting props saat pemanggilan component ini
        kelas="files" 
        headerMessage=" Upload File"
        @onSuccess="onSuccess"
        v-model="fileUploads" 
        :listData ="this.filesSurat"

        contoh di surat/formSuratMasuk
    
    - untuk Feedback dari komponent ini berupa vuex di mapGetter
            * files:'update',
            * filesStat:'updateStat'
            -jika file hapus maka isi files vuex
                akan berupa - id,deleted(boolean)dan message ini berfungsi saat updated dengan 
                memanfaat nilai deleted serta watch files 
            -jika file banyak , maka isi files vuex 
                akan berupa - id  = array id_files yang telah terupload 
                tinggal masukan id_files ke parent yang membutuhkannya 

    - komponen menyerahkan penghapusan dan penambahan tabel pivot ke parent yang memakainya. 
        maka setiap controller parent harus menyertakan destroy dan store tabel pivot untuk handle 
      komponen ini hanya memberikan file yang sudah diupload ke parent

 -->
    <div class="uploadBox">
    <form role="form" enctype="multipart/form-data" @submit.prevent="onSubmit">
       <h4>{{ headerMessage }}</h4>
        <div class="uploadBoxMain">
                <div :class="bg_alert" v-if="itemsSizes.length > 0">
                    <h6>{{ textInfo }}</h6>
                </div>
                <div class="form-group">
                    <div class="dropArea" @andragover="onChange"  :class="dragging ? 'dropAreaDragging' : ''" @dragenter="dragging=true" @dragend="dragging=false" @dragleave="dragging=false">
                        <h4 class="text-md-center">{{ dropAreaMessage }}</h4>
                        <i class="xs icon-attachment"></i>
                        <input type="file" id="items" name="items[]" required multiple @change="onChange">
                    </div>
                </div>
                <hr>
                <!-- render list item dropArea  -->
                <div class="dropArea">
                    <div class="loader" v-if="isLoaderVisible"><i class="icon-spinner spinner"></i></div>
                    <div class="scrolling-wrapper" v-if="!isLoaderVisible"> 
                        <!-- item untuk tampilan file -->
                        <div v-if="itemsNames">
                           
                            <div class="card" v-for="item,index in itemsNames">
                                <div class="cardItem">  
                                    <i v-on:click="onClose(index)" class="ls icon-cancel-circle2"></i>
                                    <i :class="iconRender(item)"></i>
                                </div>
                                <span>
                                    <!-- <p class=""> {{ index }}</p> -->
                                    <p class=""> {{ item }}</p>
                                    <p class=""> {{ index }}</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </div> 
    </form>   
    </div>

</template>
<script>

require('es6-promise').polyfill();
import { mapGetters } from "vuex";
import modal from './modal';

export default {
    components:{
        modal,
    },
    props:{
        listData:{
            default: function () {
                return [];
            },
        },  
        buttonStatus:{
            default: true
        },
        headerMessage:{
            type: String,
            default:'Upload File'
        },
        dropAreaMessage:{
            type:String,
            default:'Pilih PDF, WORD, JPG'
        },
        minItems: {
            type: Number,
            default: 1
        },
        maxItems: {
            type: Number,
            default: 5
        },
        uploadButtonMessage:{
            type:String,
            default: 'Upload'
        },
        cancelButtonMessage:{
            type:String,
            default: 'Batal'
        },
        kelas:{
            type:String,
            required:''
        },
    },
    data() {
        return {
            dragging: false,
            items: [],
            itemsAdded: '',
            itemsNames:[],
            itemsFiles: [],
            itemsFilesUpdate:[],
            itemsSizes: [],
            itemsTotalSize: '',
            formData: '',
            successMsg: '',
            errorMsg: '',
            bg_alert:'alert bg-info alert-styled-left',
            textInfo:'Pastikan Files sudah Benar',
            isLoaderVisible: false,
            typeFiles:[
                {
                    name:'Microsoft Word',
                    types:['doc','docx'],
                    icon:'icon-file-word xs'
                },
                {
                    name:'PDF',
                    types:['pdf'],
                    icon:'icon-file-pdf xs'
                },
                {
                    name:'Excel',
                    types:['xlsx'],
                    icon:'icon-file-excel xs'
                },
                {
                    name: 'Picture',
                    types:['jpeg','png','jpg'],
                    icon:'icon-file-picture xs'
                },
            ]
        }
    },
    methods:{
         bytesToSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0) return 'n/a';
                let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            if (i === 0) return bytes + ' ' + sizes[i];
            return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
        },

        onSubmit(){
        
        },

        onChange(e) {
            
            this.successMsg = '';
            this.errorMsg = '';
            this.formData = new FormData();
            
            let files = e.target.files || e.dataTransfer.files;
        
            this.isLoaderVisible = true;
            this.itemsAdded = files.length;
            this.formRender(files);
            
            
        },  

        onClose(e){ 
            if(this.$route.meta.mode =='edit'){
                let id  = this.itemsFiles[e].id; 
                if(!this.itemsFiles[e].id){
                   id= this.update[0];
                }
                
            }
           
             //console.log('Hapus Masukxxx');
            if(this.itemsFiles.length==0){
                this.removeItems(); 
            }else{
               let id  = this.itemsFiles[e].id; 
               this.itemsFiles.splice(e,1);
               this.itemsNames.splice(e,1);
               this.$store.dispatch(this.kelas+'/destroy',id);
               //console.log('Hapus Masuk');
            }    
               
        },

        formRender(files){
            let fileSizes = 0;
            for (let x in files) {
                if (!isNaN(x)) {
                    this.itemsSizes[x] = this.bytesToSize(files[x].size);
                    fileSizes += files[x].size;
                    // this.items = e.target.files[x] || e.dataTransfer.files[x];
                    if(this.$route.meta.mode =='edit'){
                        this.itemsFiles.push(files[x]);
                        this.itemsNames.push(files[x].name);
                    }else{
                        this.itemsFiles[x] = files[x];
                        this.itemsNames[x] = files[x].name;
                    }
                    // this sasdas
                    this.formData.append('items[]',files[x]);
                }
            }
            this.itemsTotalSize = this.bytesToSize(fileSizes);

            // console.log('jumlah upload');
            if ((typeof this.postMeta === 'string' && this.postMeta !== '') ||
                (typeof this.postMeta === 'object' && Object.keys(this.postMeta).length > 0)) {
                this.formData.append('postMeta', this.postMeta);
            }

            if(typeof this.postData ==='object' && this.postData !== null && Object.keys(this.postData).length > 0){
                for(var key in this.postData){
                    this.formData.append(key, this.postData[key]);
                }
            }
            
            this.isLoaderVisible = false;
            this.textInfo = 'Files Sudah Terupload';
            this.bg_alert = 'alert bg-success alert-styled-left';

            this.$store.dispatch(this.kelas+'/store',this.formData);
            this.$emit('input',files);
            
        },

        iconRender(e){
            //console.log('yuirirrorie',e);
            let type= (/[.]/.exec(e)) ? /[^.]+$/.exec(e)[0] : undefined;
            let icon= "";
            for (let i = 0; i < this.typeFiles.length; i++) {
                if( this.typeFiles[i].types.includes(type)){
                    icon = this.typeFiles[i].icon;
                } 
            }
            if(icon===""){
                icon="icon-libreoffice xs";
            }
            return icon;
        },

        removeItems() {
            this.items = '';
            this.itemsAdded = '';
            this.itemsNames =[];
            this.itemsFiles = [];
            this.itemsSizes = [];
            this.bg_alert = "alert bg-info alert-styled-left";
            this.textInfo = "Files";
            this.itemsTotalSize = '';
            this.dragging = false;
            this.isLoaderVisible=false;
        },
        onRenderList(){
            
        
        },
    },
    watch:{
        updateStat(){
            if(this.updateStat=='success'){
                this.isLoaderVisible = false;
                this.textInfo = 'Files Sudah Terupload';
                this.bg_alert = 'alert bg-success alert-styled-left'
                this.successMsg = "Sukses"; 
                this.$emit('onSuccess');
            }
        },
        listData(e){
            //console.log('sdas',this.listData);
            if(this.listData[0].length!=0){
           
                for (let i = 0; i < this.listData.length; i++) {
                    console.log('siaodisads',e[i]);
                    this.itemsNames.push(this.listData[i][0].name);
                    this.itemsFiles.push(this.listData[i][0]);
                }
                this.itemsAdded =this.listData.length;
                this.itemsFilesUpdate = this.itemsFiles;
            }

           //console.log('datas',this.itemsNames);
            
        },
        itemsNames(){
           
        },
        itemsFiles(){
            
        }
    },
    computed:{
        ...mapGetters('files',{
            filesData:'dataS',
            updateStat: 'updateStat',
            update:'update',
        }),
        
    }
}
</script>

<style scoped>

.uploadBoxMain{
    border: 3px dashed #808080;  
}

.uploadBox .dropArea h4{
    margin-top: 100px;
    text-align: center;
}

/* Drag and drop */
.uploadBox .dropArea {
    text-align: center;
    position: relative;
    width: 100%;
    height: 130px;
}

.uploadBox .dropArea input {
    position: absolute;
    cursor: pointer;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
}
.scrolling-wrapper {
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
    padding-top: 10px;
    height: 100%;
}

.scrolling-wrapper .card {
    display: inline-block;
    width: 150px;
    padding-left: 10px;
    padding-right: 10px;
}

.xs{
    font-size: 40pt;
    left: 10px;
    top:5px;
}

.ls{
    font-size: 15pt;
    float: right;
    right: -10px;
}

.scrolling-wrapper .card span{
    padding-top: 10px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    margin-top: 8px;
    height: 2.6em;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.3em;
    overflow-y: hidden;
    overflow-wrap: inherit;
    overflow-x: hidden;
    color: #555555;
    word-wrap: break-word;
}

.spinner{
    font-size: 45pt;
}

/* Loader */
.loader {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.9;
}


</style>

