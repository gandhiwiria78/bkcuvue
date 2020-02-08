<template>
    <div>
        <!-- Nonton di bitflumes laravel, buat tables sementara tentang files, -->
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
                                     <!-- Perihal  -->
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.pengirim')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.pengirim')}">
                                                 <i class="icon-cross2" v-if="errors.has('form.pengirim')"></i>
                                                    Nama Pengirim:
                                                     <p style="font-weight:bold"> 
                                                      {{ namaPenggirim }}
                                                      </p>
                                                </h5>
                                              
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.tujuan')">
                                                    <i class="icon-arrow-small-right"></i> {{ errors.first('form.tujuan') }}
                                                </small>
                                        </div>
                                        <div class="form-group" :class="{'has-error' : errors.has('form.kode')}">
                                            <!-- title -->
                                            <h5 :class="{ 'text-danger' : errors.has('form.kode')}">
                                                <i class="icon-cross2" v-if="errors.has('form.kode')"></i>
                                                  Kode Surat:
                                            </h5>
                                            <!-- text -->
                                            <div class="row container d-flex">
                                                <div class="justify-content-center align-self-center">
                                                    <h4 class="mt-2">{{ this.form.no_surat }}</h4>
                                                </div>
                                                <span class="justify-content-center align-self-center">/</span>
                                                <div class="justify-content-center align-self-center">
                                                      <input type="text" name="name_surat" class="form-control ml-12" placeholder="BKCU" v-validate="'required'" value="BKCU" :disabled="true"
                                                        data-vv-as="name_surat" v-model="form.name_surat">
                                                </div>
                                                <span class="justify-content-center align-self-center">/</span>
                                                <div class=" justify-content-center align-self-center">
                                                    <select class="form-control" name="bidang" v-model="form.bidang" data-width="100%" @change.prevent="selectKode($event.target.value)" @click="showKet">
                                                        <option disabled value="">Kode Bidang</option>
                                                        <option v-for="kode in KodeBidang" :value="kode.kode"> {{kode.kode }} 
                                                                  <p style="font-weight:bold"> {{ selected ? kode.nama : '' }}</p>
                                                        </option>
                                                    </select>
                                                </div>
                                                <span class="justify-content-center align-self-center">/</span>

                                               <div class=" justify-content-center align-self-center">
                                                     <input type="text" name="romawi" class="form-control" placeholder="romawi" v-validate="'required'" data-vv-as="tahun"
                                                        v-model="form.romawi" disabled>
                                                </div>
                                                <span class="justify-content-center align-self-center">/</span>
                                                <div class="justify-content-center align-self-center">
                                                    <input type="text" name="tahun" class="form-control" placeholder="Tahun" v-validate="'required'" data-vv-as="tahun"
                                                        v-model="form.tahun" disabled>
                                                </div>
                                                
                                            </div>
                                            <!-- error message -->
                                            <small class="text-muted text-danger" v-if="errors.has('form.kode')">
                                                <i class="icon-arrow-small-right"></i> {{ errors.first('form.kode') }}
                                            </small>
                        
                                            <small class="text-muted" v-else>&nbsp;</small>
                                    <div class="col-md-12 justify-content-center align-self-center">
                                        <p style="font-weight:bold"> {{ kodeView }}</p>
                                    </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Perihal  -->
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.perihal')}">
                                            <!-- title -->
                                            <h5 :class="{ 'text-danger' : errors.has('form.perihal')}">
                                                <i class="icon-cross2" v-if="errors.has('form.perihal')"></i>
                                                Perihal Surat:
                                            </h5>

                                            <!-- text -->
                                            <input type="text" name="name" class="form-control" placeholder="Masukan Perihal Surat " v-validate="'required|min:5'" data-vv-as="Perihal" v-model="form.perihal">
                                            <!-- error message -->
                                            <small class="text-muted text-danger" v-if="errors.has('form.perihal')">
                                                <i class="icon-arrow-small-right"></i> {{ errors.first('form.perihal') }}
                                            </small>
                                
                                            <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                    <hr />
                                    <!-- Tujuan  -->
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error' : errors.has('form.tujuan')}">
                                            <!-- title -->
                                                <h5 :class="{ 'text-danger' : errors.has('form.tujuan')}">
                                                <i class="icon-cross2" v-if="errors.has('form.tujuan')"></i>
                                                    Tujuan Surat:
                                                </h5>
                                                <!-- text -->
                                                <input type="text" name="name" class="form-control" placeholder="Masukan tujuan Surat " v-validate="'required|min:5'" data-vv-as="tujuan" v-model="form.tujuan">
                                                <!-- error message -->
                                                <small class="text-muted text-danger" v-if="errors.has('form.tujuan')">
                                                    <i class="icon-arrow-small-right"></i> {{ errors.first('form.tujuan') }}
                                                </small>

                                                <small class="text-muted" v-else>&nbsp;</small>
                                        </div>
                                    </div>
                                     <!-- upload -->
                                     <div class="col-md-12">
                                            <div class="form-group">
                                            <multi-upload
                                                   
                                                    headerMessage=" Upload File"
                                                    @onSuccess="onSuccess"
                                                    v-model="fileUploads"
                                                    :listData ="this.filesSurat">
                                            </multi-upload>
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

import { mapGetters } from "vuex";
import pageHeader from "../../../components/pageHeader.vue";
import cleave from "vue-cleave-component";
import message from "../../../components/message.vue";
import formButton from "../../../components/formButton.vue";
import formInfo from "../../../components/formInfo.vue";
import multiUpload from "../../../components/multiUploadV21";
import appModal from "../../../components/modal";

let kodesurat ;
export default {
  components: {
    message,
    formButton,
    formInfo,
    pageHeader,
    cleave,
    multiUpload,
    appModal
  },
  watch: {
    itemData() {
      this.form.no_surat = this.itemData.data[0].no_surat;
    }
  },
  data() {
    return {
      title: "Lengkapkan Surat Keluar",
      titleDesc: "Lengkapkan Surat Keluar",
      titleIcon: "icon-plus3",
      kelas: "surat",
      formData: {},
      fileUploads: [],
      namaPenggirim:'',
      form: {
        no_surat: "",
        name_surat: "BKCU",
        bidang: "",
        romawi: "",
        tahun: "",
        kode: "",
        tanggal: "",
        perihal: "",
        tujuan: "",
        id_pengelola: "",
        tipe: ""
      },
      cleaveOption: {
        date: {
          date: true,
          datePattern: ["d", "m", "Y"],
          delimiter: "-"
        },
        number: {
          numeral: true,
          numeralThousandsGroupStyle: "none",
          numeralDecimalScale: 0,
          stripLeadingZeroes: false
        },
        numeric: {
          numeral: true,
          numeralThousandsGroupStyle: "thousand",
          numeralDecimalScale: 2,
          numeralDecimalMark: ",",
          delimiter: "."
        },
        dateTime: {
          blocks: [4, 2, 2, 2, 2, 2],
          delimiters: ["-", "-", " ", ":", ":"],
          delimiterLazyShow: true
        }
      },
      cancelTitle: "Tutup",
      cancelIcon: "icon-cross",
      cancelState: "methods",
      listFiles: {},
      modalShow: false,
      modalState: "",
      modalTitle: "",
      modalColor: "",
      modalContent: "",
      modalButton: "",
      KodeBidang: [
        {
          kode: "BOG",
          nama: "BIDANG ORGANISASI"
        },
        {
          kode: "BDK",
          nama: "BIDANG DIKLAT & PEMBERDAYAAN"
        },
        {
          kode: "BPK",
          nama: "BIDANG PELAYANAN KEUANGAN"
        },
        {
          kode: "BTK",
          nama: "BIDANG TATA KELOLA"
        },
        {
          kode: "BSI",
          nama: "BIDANG SISTEM INFORMASI"
        },
        {
          kode: "GM",
          nama: "GENERAL MANAGER"
        },
        {
          kode: "DP",
          nama: "DEWAN PENGURUS"
        },
        {
          kode: "BPW",
          nama: "BADAN PENGAWAS"
        }
      ],
      Romawi:[
          'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'
      ],
      selectedKode:'',
      selectedRomawi:'',
      selected:false,
      kodeView:'',
    }
  },
  watch: {
    updateStat(e) {
      //console.log('updateStat',this.updateStat);
      if(e == 'success'){
          if(this.state==='save'){
              this.$router.push({name: this.kelas+'Keluar', params:{}});
          }
      }
    },
    itemData(e) {
      this.form.no_surat = e.data[0].no_surat;
      let Created_at = e.data[0].created_at;
      this.namaPenggirim = e.data[0].pengelola.name;
      let dates = new Date(Created_at);
      this.form.tahun = dates.getFullYear();
      this.form.romawi = this.Romawi[dates.getMonth()];

      if(this.itemDataStat === "success"){  
        // pisahkan dengan string
        this.form.kode = e.data[0].kode;
        let date = e.data[0].created_at;
        if(this.form.kode){
          let kodestring = this.form.kode.split("/");
          this.form.name_surat = kodestring[1];
          this.form.bidang = kodestring[2];
          this.form.romawi = kodestring[3];
          this.form.tahun = kodestring[4];
        }

        this.form.perihal = e.data[0].perihal;
        this.form.tujuan = e.data[0].tujuan;
        this.form.tipe = 1;
        this.$store.dispatch(this.kelas + "/getFilesSurat", [
          this.$route.params.id,
          this.form
        ]);
       this.getKodesurat();
      }
    },
    filesSurat() {

    },
    files(e){
      if(e.deleted){
        let id = e.id;
        this.$store.dispatch(this.kelas+'/destroyPivot',id);
      }
    },
    selected(){
      this.getKodesurat();
    }

  },
  created() {
    this.fecth();
    // get  tahun dan tanggal surat untuk digenerete ke Romawi dan tahun 
   
  },
  methods: {
    fecth() {
      this.$store.dispatch(this.kelas + "/getSurat", this.$route.params.id);
    },
    selectKode(e){
        this.selected = false;
        this.selectedKode = e;
    },
    selectRomawi (e){
        this.selected = false;
        this.selectedRomawi = e;
    },
    showKet(){
       this.selected=true;
    },
    getKodesurat(){
        kodesurat = this.form.no_surat 
          +'/'+ this.KodeNull(this.form.name_surat)
          +'/'+ this.KodeNull(this.form.bidang)
          +'/'+ this.KodeNull(this.form.romawi)
          +'/'+ this.KodeNull(this.form.tahun);
        this.kodeView = kodesurat; 
    },
    KodeNull(e){
      return e==''? '-': e;
    },
  // cacatan masih di kodesurat view blm masuk dibidangnya
    modalConfirmOpen(state) {
      this.modalShow = true;
      this.modalState = 'confirm-tutup';
      if(state=='back'){
        this.modalTitle = ' Batal ? '
        this.modalButton = 'Ya, Simpan';
      }else if( state == 'save'){
        this.modalTitle = 'Simpan Surat dengan kode:'+ kodesurat;
        this.modalButton = 'Ya, Simpan';
      }
      this.state = state;
    },
    modalTutup() {
      this.modalShow = false;
    },
    modalConfirmOk() {
      if(this.state == 'back'){
         
        this.$router.push({
          name:this.kelas+'Keluar',params:{}
        });

      }else if (this.state == 'save'){
        this.save();
      }
      this.modalShow = false;
    },
    save() {
      let kodeFix =
        this.form.no_surat +
        "/" +
        this.form.name_surat +
        "/" +
        this.form.bidang +
        "/" +
        this.form.romawi +
        "/" +
        this.form.tahun;
      // mengirim form melewati formData, dan ini berfungsi untuk mengirim file
      this.formData = new FormData();
      this.formData.append("no_surat", this.form.no_surat);
      this.formData.append("perihal", this.form.perihal);
      this.formData.append("kode", kodeFix);
      this.formData.append("id_pengelola", this.itemData.data[0].id_pengelola);
      this.formData.append("tujuan", this.form.tujuan);
      if(!this.files.deleted){
        this.formData.append("id_files", this.files);
      }
      this.formData.append("tipe", 1); // tipe 0 surat masuk. 1 surat keluar
      this.formData.append("status", 1);
      this.formData.append("jenis", "SK");
      // jenis surat ada apa aja ?????
      this.$validator.validateAll("form").then(result => {
        if (result) {
          this.$store.dispatch(this.kelas + "/update", [
            this.$route.params.id,
            this.formData
          ]);
        } else {
          window.scrollTo(0, 0);
          this.submited = true;
        }
      });
    },
    cancelClick() {
      this.modalConfirmOpen('back')
    },
    succesUpload() {},
    onSuccess() {},
    back() {
      this.modalShow = true;
      if (this.modalState === "success") {
        console.log('keluarrr');
        this.$router.push({ name: this.kelas+'Keluar', params: {} });
      }
    },
    fill() {}
  },
  computed: {
    // memberitahu kan ke store bahwa perlu cek autifikasi
    ...mapGetters("auth", {
      currentUser: "currentUser"
    }),
    ...mapGetters("surat", {
      itemData: "dataS",
      itemDataStat: "dataStatS",
      update: "update",
      updateStat: "updateStat",
      filesSurat: "filesSurat", // ketika update
      filesSuratStat: "filesSuratStat"
    }),
    ...mapGetters("files", {
      files: "update",
      filesStat: "updateStat"
    })
  }
};
</script>
