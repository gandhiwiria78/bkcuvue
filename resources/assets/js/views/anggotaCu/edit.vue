<template>
	<div>

		<!-- message -->
		<message v-if="errors.any('form') && submited" :title="'Oops, terjadi kesalahan'" :errorItem="errors.items">
		</message>

		<!-- main panel -->
		<form @submit.prevent="save" data-vv-scope="form">

			<!-- identitas -->
			<div class="card">
				<div class="card-body">

					<div class="row">

						<!-- nik -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>No. KTP:</h6>

								<!-- text -->
								<cleave 
									name="nik"
									v-model="form.nik" 
									class="form-control" 
									:options="cleaveOption.number16"
									placeholder="Silahkan masukkan no KTP"
									v-validate="'required'" data-vv-as="No. KTP" readonly></cleave>

							</div>
						</div>

							<!-- no_ba -->
						<div class="col-md-4" v-if="currentUser && currentUser.id_cu != 0">
							<div class="form-group" :class="{'has-error' : errors.has('form.no_ba')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.no_ba')}">
									<i class="icon-cross2" v-if="errors.has('form.no_ba')"></i>
									No. BA:</h6>

								<!-- text -->
								<input type="text" name="no_ba" class="form-control" placeholder="Silahkan masukkan no ba" v-validate="'required'"
								data-vv-as="No. BA" v-model="form.no_ba">

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.no_ba')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.no_ba') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- tanggal_masuk -->
						<div class="col-md-4" v-if="currentUser && currentUser.id_cu != 0">
							<div class="form-group" :class="{'has-error' : errors.has('form.tanggal_masuk')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.tanggal_masuk')}">
									<i class="icon-cross2" v-if="errors.has('form.tanggal_masuk')"></i>
									Tgl. Jadi Anggota:</h6>

								<!-- text -->
								<cleave name="tanggal_masuk" v-model="form.tanggal_masuk" class="form-control" :raw="false" :options="cleaveOption.date" v-validate="'required'" data-vv-as="Tgl. jadi anggota"
								placeholder="Silahkan masukkan tgl. jadi anggota"></cleave>

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.tanggal_masuk')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.tanggal_masuk') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- name -->
						<div class="col-md-4">
							<div class="form-group" :class="{'has-error' : errors.has('form.name')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.name')}">
									<i class="icon-cross2" v-if="errors.has('form.name')"></i>
									Nama:</h6>

								<!-- text -->
								<input type="text" name="name" class="form-control" placeholder="Silahkan masukkan nama" v-validate="'required|min:5'"
									data-vv-as="Nama" v-model="form.name">

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.name')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.name') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- alih waris -->
						<div class="col-md-4">
							<div class="form-group" :class="{'has-error' : errors.has('form.alih_waris')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.alih_waris')}">
									<i class="icon-cross2" v-if="errors.has('form.alih_waris')"></i>
									Nama Alih Waris:</h6>

								<!-- text -->
								<input type="text" name="alih_waris" class="form-control" placeholder="Silahkan masukkan nama alih waris" v-validate="'required'"
									data-vv-as="Nama alih waris" v-model="form.alih_waris">

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.alih_waris')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.alih_waris') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- gender -->
						<div class="col-md-4">
							<div class="form-group" :class="{'has-error' : errors.has('form.kelamin')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.kelamin')}">
									<i class="icon-cross2" v-if="errors.has('form.kelamin')"></i>
									Gender:
								</h6>

								<!-- select -->
								<select class="form-control" name="kelamin" v-model="form.kelamin" data-width="100%" v-validate="'required'"
									data-vv-as="Gender">
									<option disabled value="">Silahkan pilih gender</option>
									<option value="Pria">Pria</option>
									<option value="Wanita">Wanita</option>
								</select>

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.kelamin')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.kelamin') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- darah -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>
									Gol. Darah:
								</h6>

								<!-- select -->
								<select class="form-control" name="darah" v-model="form.darah" data-width="100%">
									<option disabled value="">Silahkan pilih golongan darah</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="AB">AB</option>
									<option value="O">O</option>
								</select>

							</div>
						</div>

						<!-- tinggi -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6> Tinggi <small>(cm)</small>:</h6>

								<!-- text -->
								<cleave name="tinggi" v-model="form.tinggi" class="form-control" :options="cleaveOption.number3" placeholder="Silahkan masukkan tinggi"></cleave>
							</div>
						</div>

						<!-- agama -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Agama:</h6>

								<!-- select -->
								<select class="form-control" name="agama" v-model="form.agama" data-width="100%">
									<option disabled value="">Silahkan pilih agama</option>
									<option value="Buddha">Buddha</option>
									<option value="Hindu">Hindu</option>
									<option value="Islam">Islam</option>
									<option value="Khatolik">Khatolik</option>
									<option value="Kong Hu Cu">Kong Hu Cu</option>
									<option value="Protestan">Protestan</option>
								</select>

							</div>
						</div>

						<!-- tanggal lahir -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Tgl. Lahir:</h6>

								<!-- input -->
								<cleave name="tanggal_lahir" v-model="form.tanggal_lahir" class="form-control" :raw="false" :options="cleaveOption.date"
									placeholder="Silahkan masukkan tgl. lahir"></cleave>

							</div>
						</div>

						<!-- tempat lahir -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Tempat Lahir:</h6>

								<!-- text -->
								<input type="text" name="tempat_lahir" class="form-control" placeholder="Silahkan masukkan tempat lahir" v-model="form.tempat_lahir">

							</div>
						</div>

						<!-- status -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>
									Status:
								</h6>

								<!-- select -->
								<select class="form-control" name="status" v-model="form.status" data-width="100%">
									<option disabled value="">Silahkan pilih status pernikahan</option>
									<option value="Belum menikah">Belum menikah</option>
									<option value="Menikah">Menikah</option>
									<option value="Janda/Duda">Janda/Duda</option>
								</select>

							</div>
						</div>

						<!-- lembaga -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Lembaga:</h6>

								<!-- text -->
								<input type="text" name="lembaga" class="form-control" placeholder="Silahkan masukkan lembaga" v-model="form.lembaga">
							</div>
						</div>

						<!-- jabatan -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Jabatan:</h6>

								<!-- text -->
								<input type="text" name="jabatan" class="form-control" placeholder="Silahkan masukkan jabatan" v-model="form.jabatan">
							</div>
						</div>

						<!-- pendidikan -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Pendidikan:</h6>

								<!-- text -->
								<input type="text" name="pendidikan" class="form-control" placeholder="Silahkan masukkan pendidikan" v-model="form.pendidikan">

							</div>
						</div>

						<!-- Provinsi -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>
									Provinsi:
								</h6>

								<!-- select -->
								<select class="form-control" name="id_provinces" v-model="form.id_provinces" data-width="100%" :disabled="modelProvinces.length == 0" @change="changeProvinces($event.target.value)">
									<option disabled value="">
										<span v-if="modelProvincesStat === 'loading'">Mohon tunggu...</span>
										<span v-else>Silahkan pilih provinsi</span>
									</option>
									<option v-for="provinces in modelProvinces" :value="provinces.id">{{provinces.name}}</option>
								</select>

							</div>
						</div>

						<!-- kabupaten -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Kabupaten:</h6>

								<!-- select -->
								<select class="form-control"  name="id_regencies" v-model="form.id_regencies" data-width="100%" @change="changeRegencies($event.target.value)" :disabled="modelRegencies.length === 0">
									<option disabled value="">
										<span v-if="modelRegenciesStat === 'loading'">Mohon tunggu...</span>
										<span v-else>Silahkan pilih kabupaten</span>
									</option>
									<option v-for="regencies in modelRegencies" :value="regencies.id">{{regencies.name}}</option>
								</select>

							</div>
						</div>

						<!-- kecamatan -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Kecamatan:</h6>

								<!-- select -->
								<select class="form-control"  name="id_districts" v-model="form.id_districts" data-width="100%" :disabled="modelDistricts.length === 0" @change="changeDistricts($event.target.value)">
									<option disabled value="">
										<span v-if="modelDistrictsStat === 'loading'">Mohon tunggu...</span>
										<span v-else>Silahkan pilih kecamatan</span>
									</option>
									<option v-for="districts in modelDistricts" :value="districts.id">{{districts.name}}</option>
								</select>

							</div>
						</div>

						<!-- kelurahan -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Kelurahan:</h6>

								<!-- select -->
								<select class="form-control"  name="id_villages" v-model="form.id_villages" data-width="100%" v-validate="'required'" data-vv-as="Desa" :disabled="modelVillages.length === 0">
									<option disabled value="">
										<span v-if="modelVillagesStat === 'loading'">Mohon tunggu... mohon tunggu</span>
										<span v-else>Silahkan pilih kelurahan</span>
									</option>
									<option v-for="villages in modelVillages" :value="villages.id">{{villages.name}}</option>
								</select>

							</div>
						</div>

						<!-- alamat -->
						<div class="col-md-8">
							<div class="form-group">

								<!-- title -->
								<h6>Alamat:</h6>

								<!-- text -->
								<input type="text" name="alamat" class="form-control" placeholder="Silahkan masukkan alamat" v-model="form.alamat">

							</div>
						</div>

						<!-- no hp -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>No. Hp:</h6>

								<!-- text -->
								<cleave 
									v-model="form.hp" 
									class="form-control" 
									:options="cleaveOption.number12"
									placeholder="Silahkan masukkan no hp"></cleave>

								<!-- error message -->
								<small class="text-muted">&nbsp;</small>	
							</div>
						</div>

						<!-- email -->
						<div class="col-md-4">
							<div class="form-group" :class="{'has-error' : errors.has('form.email')}">

								<!-- title -->
								<h6 :class="{ 'text-danger' : errors.has('form.email')}">
									<i class="icon-cross2" v-if="errors.has('form.email')"></i>
									Email:</h6>

								<!-- text -->
								<input type="text" name="email" class="form-control" placeholder="Silahkan masukkan alamat email" v-validate="'email'" data-vv-as="Email" v-model="form.email">

								<!-- error message -->
								<small class="text-muted text-danger" v-if="errors.has('form.email')">
									<i class="icon-arrow-small-right"></i> {{ errors.first('form.email') }}
								</small>
								<small class="text-muted" v-else>&nbsp;</small>
							</div>
						</div>

						<!-- kontak -->
						<div class="col-md-4">
							<div class="form-group">

								<!-- title -->
								<h6>Kontak Lainnya:</h6>

								<!-- text -->
								<input type="text" name="kontak" class="form-control" placeholder="Silahkan masukkan kontak lainnya" v-model="form.kontak">

							</div>
						</div>
						
					</div>

				</div>
			</div>

			<!-- form info -->
			<form-info></form-info>
			<br />

			<!-- form button -->
			<div class="card card-body">
				<form-button :cancelState="'methods'" :formValidation="'form'" @cancelClick="back"></form-button>
			</div>

		</form>

		<!-- modal -->
		<app-modal :show="modalShow" :state="modalState" :title="modalTitle" :content="modalContent" :color="modalColor"
		 @batal="modalTutup" @tutup="modalTutup" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalBackgroundClick">
		</app-modal>

	</div>
</template>

<script>
	import {mapGetters} from 'vuex';
	import {toMulipartedForm} from '../../helpers/form';
	import appImageUpload from '../../components/ImageUpload.vue';
	import appModal from '../../components/modal';
	import message from "../../components/message.vue";
	import formButton from "../../components/formButton.vue";
	import formInfo from "../../components/formInfo.vue";
	import dataTable from '../../components/datatable.vue';
	import Cleave from 'vue-cleave-component';

	export default {
		components: {
			appModal,
			appImageUpload,
			message,
			formButton,
			formInfo,
			Cleave,
			dataTable
		},
		data() {
			return {
				kelas: 'anggotaCu',
				id_local: '',
				cleaveOption: {
          date:{
            date: true,
            datePattern: ['Y','m','d'],
            delimiter: '-'
					},
					number16: {
            numeral: true,
            numeralIntegerScale: 16,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
          number12: {
            numeral: true,
            numeralIntegerScale: 12,
            numeralDecimalScale: 0,
						stripLeadingZeroes: false,
						delimiter: ''
					},
					number3: {
            numeral: true,
            numeralIntegerScale: 3,
            numeralDecimalScale: 0,
            stripLeadingZeroes: false
          },
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
				},
				selectedItemSimpanan: '',
				itemDataSimpanan: [],
				itemDataSimpananStat: 'success',
				columnDataSimpanan:[
					{ title: 'No.' },
					{ title: 'Nama Simpanan' },
					{ title: 'saldo' },
				],
				modalShow: false,
				modalState: '',
				modalTitle: '',
				modalColor: '',
				modalContent: '',
				submited: false,
			}
		},
		created() {
			if (this.currentUser.id_cu == 0) {
				if (this.modelCuStat != 'success') {
					this.$store.dispatch('cu/getHeader');
				}
			}
			this.form.id_cu = this.currentUser.id_cu;
			this.fetch();
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
			fetch() {
				this.$store.dispatch(this.kelas + '/editIdentitas', this.$route.params.id);
				this.$store.dispatch('provinces/get');
			},
			save() {
				const formData = this.form;
				this.$validator.validateAll('form').then((result) => {
					if (result) {
						this.$store.dispatch(this.kelas + '/updateIdentitas', [this.$route.params.id,formData]);
						this.submited = false;
					} else {
						window.scrollTo(0, 0);
						this.submited = true;
					}
				});
			},
			changeProvinces(id){
				this.$store.dispatch('regencies/getProvinces', id);
			},
			changeRegencies(id){
				this.$store.dispatch('districts/getRegencies', id);
			},
			changeDistricts(id){
				this.$store.dispatch('villages/getDistricts', id);
			},
			back() {
				if(this.mode == 'local'){
					if(this.currentUser.id_cu == 0){
						this.$router.push({name: this.kelas + 'Cu', params:{cu: 'semua'}});
					}else{
						this.$router.push({name: this.kelas + 'Cu', params:{cu: this.currentUser.id_cu}});
					}
				}else{
					this.$emit('hideUbahData');
				}
			},
			modalTutup() {
				if (this.updateStat === 'success') {
					this.back();
				}
				this.modalShow = false;
			},
			modalBackgroundClick() {
				if (this.modalState === 'success') {
					this.modalTutup;
				} else if (this.modalState === 'loading') {
					// do nothing
				} else {
					this.modalShow = false
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
			...mapGetters('provinces',{
				modelProvinces: 'dataS',
				modelProvincesStat: 'dataStatS'
			}),
			...mapGetters('regencies',{
				modelRegencies: 'dataS',
				modelRegenciesStat: 'dataStatS'
			}),
			...mapGetters('districts',{
				modelDistricts: 'dataS',
				modelDistrictsStat: 'dataStatS'
			}),
			...mapGetters('villages',{
				modelVillages: 'dataS',
				modelVillagesStat: 'dataStatS'
			}),
		}
	}
</script>