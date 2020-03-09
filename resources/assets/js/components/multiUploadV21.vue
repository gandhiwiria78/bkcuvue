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

<div class="uploader-events mb-3" style="position: relative;">
    <div class="plupload_wrapper plupload_scroll">
        <div  class="plupload_container" title="Using runtime: html5">
            <div class="plupload" >
                <div class="plupload_header">
                    <div class="plupload_header_content">
                        <div class="plupload_header_title">{{ headerMessage }}</div>
                        <div class="plupload_header_text">{{ dropAreaMessage }}</div>
                    </div>
                </div>
                <div class="plupload_content">
                    <div :class="bg_alert">
                        <h6>{{ textInfo }}</h6>
                    </div>
                    <div class="plupload_filelist_header">
                        <div class="plupload_file_name">Nama File</div>
                        <div class="plupload_file_action">&nbsp;</div>
                        <div class="plupload_file_status"><span></span></div>
                        <div class="plupload_file_size">Ukuran</div>
                        <div class="plupload_clearer">&nbsp;</div>
                    </div>
                    <ul class="plupload_filelist" >
                        <li  class="plupload_delete" v-for="item,index in itemsNames">
                            <div class="plupload_file_name"><span>{{ item }}</span></div>
                            <div class="plupload_file_action"><a @click.prevent="onClose(index)" style="display: block;"></a></div>
                            <div class="plupload_file_status">{{  }}</div>
                            <div class="plupload_file_size">{{ bytesToSize(itemsSize[index]) }}</div>
                            <div class="plupload_clearer">&nbsp;</div>
                        </li>
                    </ul>
                    <div class="plupload_filelist_footer">
                        <div class="plupload_file_name">
                            <div class="plupload_buttons" v-show="isLoad" >
                                <button type="button" class="btn btn-primary"  @click.prevent="openInput" style="cursor:pointer;">
                                    <span style="cursor:pointer;">{{ addButton }}</span>
                                </button>
                            </div>
                            
                                <span class="plupload_upload_status">Upload {{ countItems }} files</span>
                        </div>
                        <div class="plupload_file_action"></div>
                        <div class="plupload_file_status"><span class="plupload_total_status"></span></div>
                        <div class="plupload_file_size"><span class="plupload_total_file_size">{{ total() }}</span></div>
                        <div class="plupload_progress">
                            <div class="plupload_progress_container">
                                <div class="plupload_progress_bar" style="width: 0%;"></div>
                            </div>
                        </div>
                        <div class="plupload_clearer">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="moxie-shim moxie-shim-html5" style="position: absolute; top: 317px; left: 22px; width: 83px; height: 36px; overflow: hidden; z-index: 0;">
        <input
            id="input_file" type="file" name="items[]"  style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; cursor:pointer;"
            multiple accept=".docx,.pdf,.doc" tabindex="-1" @change="addFile">
    </div>
</div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
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
        uploadButton:{
            type:String,
            default: 'Upload'
        },
        addButton:{
            type:String,
            default:'Tambah File'
        },  
        cancelButtonMessage:{
            type:String,
            default: 'Batal'
        },
        
  },
  data(){
      return{
           dragging:true,
           isLoad:true,
           kelas:'files',
           isUpload:false,
           itemsCache:[],
           itemsFiles:[],
           itemsSize:[],
           itemsNames:[],
           countItems:0,
           totalSizes:0,
           textInfo:'Pastikan Files sudah Benar',
           bg_alert: 'alert bg-info alert-styled-left',
           formData: '',
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
            ],
      }
  },
  methods:{
    bytesToSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes === 0) return '0 KB';
            let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        if (i === 0) return bytes + ' ' + sizes[i];
        return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
    },

    addFile(e){
        this.formData = new FormData();
        let files = e.target.files || e.dataTransfer.files;
        this.countItems = files.length;
        this.isLoad=false; // 
        this.formRender(files);
    },
    openInput(){
        $('#input_file').trigger('click');
    },
    total(){
        if(this.itemsSize.length!=0){
            let totalSIZE=0;
            for(let i in this.itemsSize){
                totalSIZE +=Number(this.itemsSize[i]);
                
            }
            this.totalSizes = totalSIZE;
            return this.bytesToSize(totalSIZE);
            
        }else{
            return '0 kb';
        }
    },
    formRender(files){
        let fileSizes = 0;
         for (let x in files) {
             if (!isNaN(x)) {
                 // 725844 = 725.85 kb
                if(files[x].size<1025000){
                    fileSizes += files[x].size;
                    console.log('size',files[x].size);
                    // this.items = e.target.files[x] || e.dataTransfer.files[x];
                    this.itemsSize.push(files[x].size);
                    this.itemsFiles.push(files[x]);
                    this.itemsNames.push(files[x].name);
                    // this sasdas
                    
                    this.formData.append('items[]',files[x]);
                    this.isUpload=true;

                }else{
                    this.isLoad = true;
                    this.isUpload=false;
                    this.textInfo='File '+files[x].name+' terlalu besar, file harus dibawah 1 mb';
                    this.bg_alert = "alert bg-danger alert-styled-left"
                    break;
                }
             }else{
                 this.isLoad=true;
             }
        }
        if(this.isUpload){
            this.totalSizes = fileSizes;
            //console.log(files);
            if ((typeof this.postMeta === 'string' && this.postMeta !== '') ||
                (typeof this.postMeta === 'object' && Object.keys(this.postMeta).length > 0)) {
                this.formData.append('postMeta', this.postMeta);
            }

            if(typeof this.postData ==='object' && this.postData !== null && Object.keys(this.postData).length > 0){
                for(var key in this.postData){
                    console.log('postData',this.postData);
                    this.formData.append(key, this.postData[key]);
                }
            }
            
            this.isLoaderVisible = false;
            this.textInfo = 'Files Sudah Terupload';
            this.bg_alert = 'alert bg-success alert-styled-left';
            
            this.$store.dispatch(this.kelas+'/store',this.formData);
            this.$emit('input',files);
        }
    },
    onClose(e){
        let id;
        if(this.$route.meta.mode =='edit'){
            id  = this.itemsFiles[e].id; 
            if(!this.itemsFiles[e].id){
                id= this.update[0];
            }
            this.$store.dispatch(this.kelas+'/destroy',id);
             
        }else{
            id = this.itemsCache[e];
            this.$store.dispatch(this.kelas+'/destroyDraft',id)
            this.itemsCache.splice(e,1);
        }

        this.itemsFiles.splice(e,1);
        this.itemsNames.splice(e,1);
        this.itemsSize.splice(e,1);
        
       
        if(this.itemsFiles.length===0){
            this.removeItems(); 
        } 
        
    },
    removeItems() {
        this.dragging=true;
        this.itemsFiles=[];
        this.itemsSize=[];
        this.itemsNames=[];
        this.countItems=0;
        this.totalSizes=0;
        
    },
  },
  watch:{
    updateStat(){
        if(this.updateStat=='success'){
            this.isLoad=true;
            this.$emit('onSuccess');
        }
    },
    listData(e){
        //console.log('sdas',this.listData);
        if(e.length!=0){
            for (let i = 0; i < e.length; i++) {
                try {
                    console.log('e',e.length);
                    this.itemsNames.push(e[i][0].name);
                    this.itemsFiles.push(e[i][0]);
                    this.itemsSize.push(e[i][0].size);
                } catch (error) {
                    
                }
                
            }
            this.itemsAdded =e.length;
            this.itemsFilesUpdate = this.itemsFiles;
        }
    },
    update(e){

        for (let i = 0; i < e.length; i++) {
            this.itemsCache.push(e[i]);
        }
    }
  },
  computed:{
    ...mapGetters('files',{
        filesData:'dataS',
        updateStat: 'updateStat',
        update:'update',
    }),
    
 }
};
</script>



