<template>
	<div>
		<!-- header -->
		<page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" :level="2" :level2Title="level2Title"
		 :level2Route="kelas" @level2Back="back()"></page-header>

		<!-- content -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">

					<!-- create -->
					<div v-if="$route.meta.mode == 'create'">

						<!-- check nik -->
						<div class="card card-body">	
							<div class="row">
								<div class="col-12">
									<h6>
										Silahkan masukkan NIK anggota CU untuk memastikan apakah data anggota CU dengan NIK tersebut sudah terdaftar di SIMO
									</h6>
								</div>
								<div class="col-12 pb-2">
									<!-- text -->
									<cleave 
										name="nik"
										v-model="nik" 
										class="form-control" 
										:options="cleaveOption.number16"
										placeholder="Silahkan masukkan no KTP" :disabled="isNew"></cleave>
								</div>

								<div class="col-4">
									<div class="row">
										<div class="col-6 pb-2">
											<button class="btn btn-primary btn-block" @click.prevent="cariData"  :disabled="nik == ''"><i class="icon-search4"></i> Cari</button>
										</div>
										<div class="col-6 pb-2" v-if="itemDataStat != ''">
											<button class="btn btn-warning btn-block" @click.prevent="resetData"><i class="icon-reset"></i> Reset pencarian</button>
										</div>
									</div>
									
								</div>

								<!-- loading -->
								<div class="col-12" v-if="itemDataStat == 'loading'">
									<hr/>
									<div class="progress">
										<div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" style="width: 100%">
											<span class="sr-only">100% Complete</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- data not exist -->
						<div class="alert bg-success text-white alert-styled-left " v-if="itemDataStat == 'success' && Object.keys(itemData).length == 0">
							<span class="font-weight-semibold">NIK tidak terdaftar di SIMO, maka silahkan menambahkan data anggota CU baru.
							</span>
						</div>

						<form-create v-if="itemDataStat == 'success' && Object.keys(itemData).length == 0" :nik="nik" :mode="'create_new'"></form-create>

						<!-- data exist -->
						<div class="alert bg-warning text-white alert-styled-left " v-if="Object.keys(itemData).length != 0">
							<span class="font-weight-semibold">NIK sudah terdaftar di SIMO. Apabila ingin menambahkan anggota tersebut menjadi anggota cu maka silahkan tambahkan no. ba dan tgl. jadi anggota. 
							</span>
						</div>

						<form-create v-if="Object.keys(itemData).length != 0"  :itemData="itemData" :mode="'create_old'"></form-create>
						
					</div>

					<!-- edit -->
					<form-create v-if="$route.meta.mode == 'edit'" :mode="'edit'"></form-create>

				</div>
			</div>
		</div>

	</div>
</template>

<script>
	import {mapGetters} from 'vuex';
	import pageHeader from "../../components/pageHeader.vue";
	import appModal from '../../components/modal';
	import anggotaCuAPI from '../../api/anggotaCu.js';
	import Cleave from 'vue-cleave-component';
	import formCreate from "./create.vue";	
	import formEdit from "./edit.vue";	

	export default {
		components: {
			pageHeader,
			appModal,
			formCreate,
			formEdit,
			Cleave
		},
		data() {
			return {
				title: '',
				titleDesc: '',
				titleIcon: '',
				kelas: 'anggotaCu',
				level2Title: 'Anggota CU',
				isNew: false,
				itemData: {},
				itemDataStat: '',
				nik: '',
				isEdit: false,
				cleaveOption: {
          number16: {
            numeral: true,
            numeralIntegerScale: 16,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
				},
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit'){
				this.title = 'Ubah ' + this.level2Title;
				this.titleDesc = 'Mengubah ' + this.level2Title;
				this.titleIcon = 'icon-pencil5';
			}else{
				this.title = 'Tambah ' + this.level2Title;
				this.titleDesc = 'Menambah ' + this.level2Title;
				this.titleIcon = 'icon-plus3';
			}
		},
		watch: {
			updateStat(value) {
				this.modalShow = true;
				this.modalState = value;
				this.modalColor = '';

				if (value === "success") {
				this.modalTitle = this.updateResponse.message;
				} else {
					this.modalTitle = 'Oops terjadi kesalahan :(';
					this.modalContent = this.updateResponse;
				}
			}
		},
		methods: {
			cariData(){
				this.itemDataStat = 'loading';
				this.isNew = false;

				anggotaCuAPI.cariData(this.nik)
        .then((response) => {
					if(response.data.model){
						this.itemData = response.data.model;
					}else{
						this.itemData = {};
						this.isNew = true;
					}
					this.itemDataStat = 'success';
        })
        .catch((error) => {
					this.itemData = error.response;
          this.itemDataStat = 'fail';
				});
			},
			showUbahData(){
				this.isEdit = true;
			},
			hideUbahData(){
				this.isEdit = false;
			},
			resetData(){
				this.nik = '';
				this.itemData = {};
				this.isNew = false;
				this.itemDataStat = '';
			},
			back(){
				if(this.currentUser.id_cu == 0){
					this.$router.push({name: this.kelas + 'Cu', params:{cu: 'semua'}});
				}else{
					this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
				}
			},
		},
		computed: {
			...mapGetters('auth', {
				currentUser: 'currentUser'
			}),
			...mapGetters('anggotaCu', {
				form: 'data',
				formStat: 'dataStat',
				rules: 'rules',
				options: 'options',
				updateResponse: 'update',
				updateStat: 'updateStat'
			}),
		}
	}
</script>