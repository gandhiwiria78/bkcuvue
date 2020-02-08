<template>
    <div>
        <!-- page-header -->
        <page-header :title="title" :titleDesc="titleDesc" :title-icon="titleIcon" > </page-header>

        <!-- content -->
        <div class="page-content pt-0">
            <div class="content-wrapper">
                <div class="content">
                    <form @submit.prevent="modalConfirmOpen('save')" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kode Surat  -->
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.kode')}">
                                            <!-- title -->
                                            <h5 :class="{ 'text-danger' : errors.has('form.kode')}">
                                            <i class="icon-cross2" v-if="errors.has('form.kode')"></i>
                                                Kode Surat:
                                            </h5>
                                            <!-- text -->
                                            <input type="text" name="name" class="form-control" placeholder="Masukan Kode Surat" v-validate="'required'" data-vv-as="kode" v-model="form.kode">
                                            <!-- error message -->
                                            <small class="text-muted text-danger" v-if="errors.has('form.kode')">
                                                 <i class="icon-arrow-small-right"></i> {{ errors.first('form.kode') }}
                                             </small>

                                             <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.tujuan')}">
                                            <!-- title -->
                                            <h5 :class="{ 'text-danger' : errors.has('form.tujuan')}">
                                            <i class="icon-cross2" v-if="errors.has('form.tujuan')"></i>
                                                Tujuan
                                            </h5>
                                            <!-- text -->
                                            <input type="text" name="name" class="form-control" placeholder="Masukan tujuan Surat" v-validate="'required'" data-vv-as="tujuan" v-model="form.tujuan">
                                            <!-- error message -->
                                            <small class="text-muted text-danger" v-if="errors.has('form.tujuan')">
                                                 <i class="icon-arrow-small-right"></i> {{ errors.first('form.tujuan') }}
                                             </small>
                                             <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.perihal')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.perihal')}">
                                                <i class="icon-cross2" v-if="errors.has('form.perihal')"></i>
                                                    Perihal
                                                </h5>
                                                <!-- text -->
                                                <input type="text" name="name" class="form-control" placeholder="Masukan perihal Surat" v-validate="'required'" data-vv-as="perihal" v-model="form.perihal">
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.perihal')">
                                                     <i class="icon-arrow-small-right"></i> {{ errors.first('form.perihal') }}
                                                 </small>
                                                 <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.pengirim')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.pengirim')}">
                                                <i class="icon-cross2" v-if="errors.has('form.pengirim')"></i>
                                                    Pengirim
                                                </h5>
                                                <!-- text -->
                                                <input type="text" name="name" class="form-control" placeholder="Masukan pengirim Surat" v-validate="'required'" data-vv-as="pengirim" v-model="form.pengirim">
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.pengirim')">
                                                     <i class="icon-arrow-small-right"></i> {{ errors.first('form.pengirim') }}
                                                 </small>
                                                 <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.penerima')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.penerima')}">
                                                <i class="icon-cross2" v-if="errors.has('form.penerima')"></i>
                                                    Penerima
                                                </h5>
                                                <!-- text -->
                                                <input type="text" name="name" class="form-control" placeholder="Masukan penerima Surat" v-validate="'required'" data-vv-as="penerima" v-model="form.penerima">
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.penerima')">
                                                     <i class="icon-arrow-small-right"></i> {{ errors.first('form.penerima') }}
                                                 </small>
                                                 <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.terimamelalui')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.terimamelalui')}">
                                                <i class="icon-cross2" v-if="errors.has('form.terimamelalui')"></i>
                                                    Terima Melalui
                                                </h5>
                                                <!-- text -->
                                                <input type="text" name="name" class="form-control" placeholder="Terima Melalui" v-validate="'required'" data-vv-as="terimamelalui" v-model="form.terimamelalui">
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.terimamelalui')">
                                                     <i class="icon-arrow-small-right"></i> {{ errors.first('form.terimamelalui') }}
                                                 </small>
                                                 <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <multi-upload-v2
                                            headerMessage=" Upload File"
                                            @onSuccess="onSuccess"
                                            v-model="fileUploads" 
                                            :listData ="this.filesSurat"
                                        >

                                        </multi-upload-v2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <form-button
                                    :cancelTitle="cancelTitle"
                                    :cancelIcon="cancelIcon"
                                    :cancelState="cancelState"
                                    :formValidation="'form'"
                                    @cancelClick="cancelClick">
                                </form-button>
                            </div>
                         </div>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->
        <app-modal :show="modalShow" :state="modalState" :title="modalTitle" :button="modalButton" @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalTutup">
        </app-modal>
    </div>
</template>
<script>

import { mapGetters } from 'vuex';
import pageHeader from "../../../components/pageHeader.vue";
import multiUpload from '../../../components/multiUploadV2';
import multiUploadV2 from '../../../components/multiUploadV21.vue';
import formButton from '../../../components/formButton.vue';
import appModal from '../../../components/modal';

export default {

    components:{
        pageHeader,
        multiUpload,
        formButton,
        appModal,
        multiUploadV2
    },

    data(){
        return{
            title:'Surat Masuk',
            titleDesc:'Surat Masuk',
            titleIcon:'icon-plus3',
            kelas:'surat',
            form:{
                kode:'',
                perihal:'',
                tujuan:'',
                pengirim:'',
                terimamelalui:'',
                penerima:'',
                tipe:0
            },
            formData:{},
            fileUploads:[],
            cancelTitle: 'Tutup',
            cancelIcon: 'icon-cross',
            cancelState: 'methods',
            state:'',
            modalShow: false,
            modalState: '',
            modalTitle: '',
            modalColor: '',
            modalContent: '',
            modalButton:'',
            fileUploads:[],
            buttonUploadstatus:true,
        }
    },

    watch:{
        itemDatas(e){
            
            if(this.$route.meta.mode == 'edit'){
                if(this.itemDataStats =="success"){  
                    this.form.kode = e[0].kode;
                    this.form.tujuan = e[0].tujuan;
                    this.form.perihal = e[0].perihal;
                    this.form.terimamelalui = e[0].terima_melalui;
                    this.form.pengirim = e[0].pengirim;
                    this.form.penerima = e[0].penerima;
                    this.form.tipe = 0;
                    this.buttonUploadstatus = false;
                    this.$store.dispatch(this.kelas + '/getFilesSurat', [
                        this.$route.params.id,
                        this.form,
                    ]);

                }
            } else {
                this.buttunUploadstatus = true;
            }
        },
        files(e){
            if(e.deleted){
                let id = this.files.id;
                console.log(id);
                this.$store.dispatch(this.kelas+'/destroyPivot',id);
            }
        },
        updateStat(e){
            if(e == 'success'){
                if(this.state=='save'){
                    this.$router.push({name: this.kelas+'Masuk', params:{}});
                }
            }
        },
        itemDataStats(){
            if(this.itemDataStats=='success'){
                
            }
        },  
        filesSuratStat(){
            
        }
    },
    
    created(){
        this.fecth();
    },

    methods:{
        fecth(){
           if(this.$route.meta.mode == 'edit'){
               this.$store.dispatch(this.kelas + '/getSuratMasuk', this.$route.params.id);
           }
           else{
               
           }
        },
        modalConfirmOpen(state){
          this.modalShow = true;
          this.modalState = 'confirm-tutup';
          if(state=='back'){
              this.modalTitle = 'Batal menambah Surat Masuk';
              this.modalButton = 'Ya, Batal';
          }else if (state == 'save'){
              this.modalTitle = 'Simpan Data Surat'+ this.form.kode;
              this.modalButton = 'Ya, Simpan';
          }
          this.state = state;
        },
        modalTutup(){
            this.modalShow = false;
            this.$store.dispatch(this.kelas + '/resetUpdateStat2');
        },
        modalConfirmOk(){
            if(this.state =='back'){
               
            }else if (this.state =='save'){
                this.save();
            }
            this.modalShow = false;
        },
        save(){
            this.formData = new FormData();
            this.formData.append('kode',this.form.kode);
            this.formData.append('tujuan',this.form.tujuan);
            this.formData.append('perihal',this.form.perihal);
            this.formData.append('pengirim',this.form.pengirim);
            this.formData.append('penerima',this.form.penerima);
            this.formData.append('terima_melalui',this.form.terimamelalui);
            
            if(!this.files.deleted){
                this.formData.append('id_files',this.files);
            }

            this.formData.append('tipe',0);
            this.formData.append('status',1);
            this.$validator.validateAll('form').then((result)=>{
                if(result){
                    // cek jika update atau buat baru 
                    if(this.$route.meta.mode == 'edit'){
                        this.$store.dispatch(this.kelas+ '/updateSuratMasuk', [ this.$route.params.id, this.formData ]) ;
                    }else{
                        console.log('create');
                        this.$store.dispatch(this.kelas+'/storeSuratMasuk', this.formData);
                    }
                }else{
                    window.scrollTo(0,0);
                    this.submited = true;
                }
            });
        },
        cancelClick(){
            this.back();
        },
        onSuccess(){
            
        },
        back(){
           this.$router.push({
                    name:this.kelas+'Masuk', params:{}
            });
        }
    },
    computed:{
        ...mapGetters('surat',{
			itemDatas:'dataS2',
            itemDataStats:'dataStats2',
            filesSurat: 'filesSurat', 
            filesSuratStat:'filesSuratStat',
            update: 'update', 
            updateStat: 'updateStat',
        }),
        ...mapGetters('files',{
            files:'update',
            filesStat:'updateStat'
        }),
    }
}
</script>
