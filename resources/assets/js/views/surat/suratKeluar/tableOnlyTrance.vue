<template>
    <div>
    <data-viewer :title="title" :columnData="columnData" :itemData="itemData" :query="query" :itemDataStat="itemDataStat" :excelUrl="excelUrl" :isUploadExcel="false" @fetch="fetch">
     		 <!-- button desktop -->
			<template slot="button-desktop">
                <button @click.prevent="modelConfirmOpen('restore')"  class="btn btn-light mb-1" >
                    <i class="icon-plus3"></i> Pulihkan Nomor Surat
                </button>
				    
			</template>
			<!-- button mobile -->
			<template slot="button-mobile">
                <button @click.prevent="modelConfirmOpen('restore')" class="btn btn-light btn-block mb-1" >
                    <i class="icon-plus3"></i> Pulihkan Nomor Surat
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
			itemDataStat(e){
				console.log('ee',e);
			}
		},
        methods: {
            // untuk mengambil data awal dengan memakai function di store
            fetch(params){
				//console.log('kelas',this.kelas)
				this.$store.dispatch(this.kelas + '/indexTranceSuratKeluar', params);
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
				}else if (state =='restore'){
					this.modalShow = true;
					this.modalColor = 'bg-primary';
					this.modalTitle = 'Pulihkan Nomor Surat';
					this.modalButton = 'Iya, Pulihkan';
					this.modalState = 'normal1';
					this.modalSize = 'modal-full';
				}
			},
			modalTutup() {
				this.modalShow=false;
				this.fetch(this.query);
			},
            selectedRow(item){
				this.selectedItem = item;
				//console.log(this.selectedItem);
			},

			modalConfirmOk() {
				if(this.state == 'pulihkan' ){
					this.$store.dispatch(this.kelas + '/restoreSuratMasuk',this.form);
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
				this.fetch(this.query);
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
				itemData:'dataS2',
				itemDataStat:'dataStats2',
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
