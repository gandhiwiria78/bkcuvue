<template>
    <div>
    <data-viewer :title="title" :columnData="columnData" :itemData="itemData" :query="query" :itemDataStat="itemDataStat" :excelUrl="excelUrl" :isUploadExcel="false" @fetch="fetch">
     		 <!-- button desktop -->
			<template slot="button-desktop">
                <button @click.prevent="modelConfirmOpen('simpan')"  class="btn btn-light mb-1" >
                    <i class="icon-plus3"></i> Tambah Nomor Surat
                </button>
				 <button @click.prevent="ubahData(selectedItem.id)"  class="btn btn-light mb-1"  :disabled="!selectedItem.id">
                  	<i class="icon-pencil5"></i> Edit
                </button>
				 <button @click.prevent="modelConfirmOpen('hapus')" class="btn btn-light  mb-1"  :disabled="!selectedItem.id">
                    <i class="icon-pencil5"></i> Hapus
                </button>
			</template>
			<!-- button mobile -->
			<template slot="button-mobile">
                <button @click.prevent="modelConfirmOpen('simpan')" class="btn btn-light btn-block mb-1" >
                    <i class="icon-plus3"></i> Tambah Nomor Surat
                </button>
                <button @click.prevent="ubahData(selectedItem.id)" class="btn btn-light btn-block mb-1"  :disabled="!selectedItem.id">
                    <i class="icon-pencil5"></i> Edit
                </button>
				 <button @click.prevent="modelConfirmOpen('hapus')" class="btn btn-light btn-block mb-1"  :disabled="!selectedItem.id">
                    <i class="icon-pencil5"></i> Hapus
                </button>
			</template>
         	<!-- Tabel Show -->
        	<template slot="item-desktop" slot-scope="props">
				<tr :class="{ 'bg-info': selectedItem.id == props.item.id }" @click="selectedRow(props.item)" class="text-nowrap">
					<td v-if="!columnData[0].hide">
						{{ props.index + 1 + (+itemData.current_page-1) * +itemData.per_page + '.'}}
					</td>
					<td v-if="!columnData[1].hide">
						<check-value :value="props.item.no_surat"></check-value>
					</td>
					<td v-if="!columnData[2].hide">
						<check-value :value="props.item.pengelola.name"></check-value>
					</td>
					<td v-if="!columnData[2].hide">
						<check-value :value="props.item.kode"></check-value>
					</td>
					<td v-if="!columnData[2].hide">
						<check-value :value="props.item.perihal"></check-value>
					</td>
					<td v-if="!columnData[2].hide">
						<check-value :value="props.item.tujuan"></check-value>
					</td>
					<td v-if="!columnData[3].hide">
						<check-value :value="props.item.created_at"></check-value>
					</td>
					<td v-if="!columnData[4].hide" >
						<check-value :value="props.item.updated_at"></check-value>
					</td>
				</tr>
			</template>		
    </data-viewer>
		<app-modal :show="modalShow" :state="modalState" :size="modalSize" :color="modalColor" :title="modalTitle" :content="modalContent" :button="modalButton" @tutup="modalTutup" @confirmOk="modalConfirmOk('simpan')" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalTutup">
			<template slot="modal-title">
				{{ modalTitle }}
			</template>
			<!-- buat selectbox untuk memilih bagian jabatan -->
			<template slot="modal-body1">
				<!-- test -->
				<modal-surat-keluar v-if="this.state==='simpan'" :selectItemP="changePengelola"></modal-surat-keluar>
				<!-- divider -->
				<hr>
			</template>
			<template slot="modal-footer1">
				<!-- button -->
				<button class="btn btn-light" @click="modalTutup">
					<i class="icon-cross"></i> Tutup</button>
				<button class="btn btn-light" @click="modalGenereteNomorSurat">
					<i class="icon-plus3"></i> Tambahkan
				</button>
			</template>
		</app-modal>
	</div>
</template>

<script>
    import { mapGetters } from 'vuex';
	import truncate from 'vue-truncate-collapsed';
	import DataViewer from '../../../components/dataviewer2.vue';
	import checkValue from '../../../components/checkValue.vue';
	import appModal from '../../../components/modal';
	import modalSuratKeluar from './modelNomorSuratKeluar.vue';
	
    export default{
        components :{
		   DataViewer,
		   truncate,
		   checkValue,
		   appModal,
		   modalSuratKeluar,
        },
		props:['title','kelas','columnData'],
        data(){
            return{
                selectedItem: [],
				query: {
					order_column: "no_surat",
					order_direction: "asc",
					filter_match: "and",
					limit: 10,
					page: 1
				},
				form:{
					no_surat:'',
					id_pengelola:'',
					kode:'',
				},
				formupload:{
					perihal:'',
					tujuan:'',
					tanggal:'',
				},
				excelUrl:'',
				state: '',
				modalShow: false,
				modalState: '',
				modalColor: '',
				modalSize: '',
				modalTitle: '',
				modalButton: '',
				modalContent: '',

            }
        },
		created(){
			this.fetch(this.query);
		},
		watch: {
			'$route' (to, from){
				this.fetch(this.query);
			},
			updateStat(e){
				if(e=='success'){
					this.modalTutup();
					this.fetch();
				}
			}
		},
        methods: {
            // untuk mengambil data awal dengan memakai function di store
            fetch(params){
				//console.log('kelas',this.kelas)
				this.$store.dispatch(this.kelas + '/indexSuratKeluar', params);
				this.excelUrl = this.kelas;
			},
			// untuk modal confirm 
            modelConfirmOpen(state, isMobile, itemMobile){
				
				this.modalShow = true;
				this.modalState = 'confirm-tutup';
				this.state = state;
				// console.log('daata',state);
				if(isMobile){
					this.selectedItem = itemMobile;
				}else if(state =='hapus'){
					this.modalTitle = 'Hapus ' + this.title + ' ' + this.selectedItem.kode + ' ?';
					this.modalButton = 'Iya, Hapus';
				}else if(state == 'update'){
					this.modalTitle=  'Update' + this.title + ' ' + this.selectedItem.kode + '?' ;
				}else if (state =='simpan'){
					this.modalShow = true;
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Tambah Nomor Surat';
					this.modalButton = 'Iya, Tambahkan';
					this.modalState = 'normal1';
					this.modalSize = 'modal-full';
				}
			},
			modalTutup() {
				this.modalShow=false;
				this.$store.dispatch(this.kelas+'/resetDataStat');
				if(this.state=='hapus'){
                    this.fetch(this.query);
                }
			},
            selectedRow(item){
				this.selectedItem = item;
				console.log(this.selectedItem);
			},

			modalConfirmOk() {
				if (this.state == 'hapus') {
					this.$store.dispatch(this.kelas + '/softDestroySuratKeluar', this.selectedItem.id);
				} else if (this.state == "update"){
					this.$store.dispatch(this.kelas + '/update', this.selectedItem.id);
				} else if(this.state == 'simpan' ){
					this.$store.dispatch(this.kelas + '/store',this.form);
				} 
				this.modalTutup();
			},

			modalGenereteNomorSurat(){
				let generete = 0;
				if(this.itemData.data.length === 0){
					generete = generete+1;
				}else{
					generete = this.itemData.data[this.itemData.total-1].no_surat;
					generete = generete+1;
				}
				
				this.form.no_surat = generete;
				this.form.id_pengelola = this.dataSelect.id;
				this.modalConfirmOk();
			},

			changePengelola(){
				
			},

			ubahData(item) {
				this.$router.push({name: this.kelas + 'keluarEdit', params: { id: item}});
			},

			uploadfile(){
				
			},
		},
      	computed:{
			// memberitahu kan ke store bahwa perlu cek autifikasi 
			...mapGetters('auth',{
				currentUser : 'currentUser',
			}),
			... mapGetters('surat',{
				itemData:'dataS',
				itemDataStat:'dataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),
			... mapGetters('pengelola',{
				dataSelect: 'data',
			}),
			modalForm(){
				let newData = {

				};
				return newData;
			}
		}
    }
</script>
