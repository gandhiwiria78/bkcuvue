<template>
	<div>
		<form @submit.prevent="save" data-vv-scope="formPinjaman">

		<!-- message -->
		<message v-if="message.show" @close="messageClose" :title="'Oops terjadi kesalahan'" :errorData="message.content" :showDebug="false">
		</message>

		<div class="row">

			<!-- cu -->
			<div class="col-md-12" v-if="currentUser.id_cu === 0">
				<div class="form-group" :class="{'has-error' : errors.has('formPinjaman.cu.id')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('formPinjaman.cu.id')}">
						<i class="icon-cross2" v-if="errors.has('formPinjaman.cu.id')"></i>
						CU:
					</h5>

					<!-- select -->
					<select class="form-control" name="cu_id" v-model="formPinjaman.cu.id" data-width="100%" @change="changeCu($event.target.value)" v-validate="'required'" data-vv-as="CU" :disabled="modelCU.length === 0">
						<option disabled value="0">
							<span v-if="modelCUStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih CU</span>
						</option>
						<option v-for="cu in modelCU" :value="cu.id">{{cu.name}}</option>
					</select>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formPinjaman.cu.id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formPinjaman.cu.id') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- produk cu -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('formPinjaman.produk_cu_id')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('formPinjaman.produk_cu.id')}">
						<i class="icon-cross2" v-if="errors.has('formPinjaman.produk_cu.id')"></i>
						Produk CU:
					</h5>

					<!-- select -->
					<select class="form-control" name="produk_cu_id" v-model="formPinjaman.produk_cu.id" data-width="100%" @change="changeProdukCu($event.target.value)" v-validate="'required'" data-vv-as="Produk CU" :disabled="modelProdukCu.length === 0">
						<option disabled value="0">
							<span v-if="modelProdukCuStat === 'loading'">Mohon tunggu...</span>
							<span v-else>Silahkan pilih Produk CU</span>
						</option>
						<option v-for="produk in modelProdukCu" :value="produk.id">{{produk.name}}</option>
					</select>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formPinjaman.produk_cu.id')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formPinjaman.produk_cu.id') }}
					</small>
					<small class="text-muted" v-else>&nbsp;</small>
				</div>
			</div>

			<!-- saldo -->
			<div class="col-md-12">
				<div class="form-group" :class="{'has-error' : errors.has('formPinjaman.saldo')}">

					<!-- title -->
					<h5 :class="{ 'text-danger' : errors.has('formPinjaman.saldo')}">
						<i class="icon-cross2" v-if="errors.has('formPinjaman.saldo')"></i>
						Saldo:
					</h5>

					<!-- text -->
					<cleave 
						name="saldo"
						v-model="formPinjaman.saldo" 
						class="form-control" 
						:options="cleaveOption.numeric"
						placeholder="Silahkan masukkan jumlah saldo"
						v-validate="'required'" data-vv-as="Saldo" ></cleave>

					<!-- error message -->
					<small class="text-muted text-danger" v-if="errors.has('formPinjaman.saldo')">
						<i class="icon-arrow-small-right"></i> {{ errors.first('formPinjaman.saldo') }}
					</small>
					<small class="text-muted" v-else>&nbsp;
					</small>
				</div>
			</div>

		</div>

		<!-- divider -->
		<hr>
		
		<!-- tombol desktop-->
		<div class="text-center d-none d-md-block">
			<button type="button" class="btn btn-light" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>

			<button type="submit" class="btn btn-primary" :disabled="formPinjaman.produk_cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>
		</div>  

		<!-- tombol mobile-->
		<div class="d-block d-md-none">
			<button type="submit" class="btn btn-primary btn-block pb-2" :disabled="formPinjaman.produk_cu_id == ''">
				<i class="icon-floppy-disk"></i> Simpan</button>

			<button type="button" class="btn btn-light btn-block pb-2" @click.prevent="tutup">
				<i class="icon-cross"></i> Tutup</button>
		</div> 

		</form>

	</div>
</template>

<script>
	import _ from 'lodash';
	import { mapGetters } from 'vuex';
	import checkValue from '../../components/checkValue.vue';
	import Message from "../../components/message.vue";
	import Cleave from 'vue-cleave-component';
	import produkCuAPI from '../../api/produkCu.js';

	export default {
		props: ['mode','selected'],
		components: {
			checkValue,
			Message,
			Cleave
		},
		data() {
			return {
				title: '',
				kelas: 'aktivis',
				formPinjaman:{
					anggota_id: '',
					saldo: '',
					cu: {
						id: 0,
						name: ''
					},
					produk_cu: {
						id: 0,
						name: ''
					}
				},
				modelProdukCu: [],
				modelProdukCuStat: '',
				cleaveOption: {
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
					},
				},
				message: {
					show: false,
					content: ''
				},
				submited: false,
			}
		},
		created(){
			this.fetchCU();

			if(this.mode == 'edit'){
				if(this.modelCUStat == 'success'){
					this.formPinjaman = this.selected;
				}
			}
		},
		watch: {
			modelCUStat(value){
				if(value === "success"){
					if(this.mode == 'edit'){
						this.formPinjaman = this.selected;
					}
				}
			},
		},
		methods: {
			changeCu(id){
				let cu;
				if(id != 0){
					cu = _.find(this.modelCU, function(o){
						return o.id == id;
					});
				}
				this.formPinjaman.cu.name = cu.name;
				this.fetchProdukCu(id);
			},
			changeProdukCu(id){
				let produk_cu;
				if(id != 0){
					produk_cu = _.find(this.modelProdukCu, function(o){
						return o.id == id;
					});
				}
				this.formPinjaman.produk_cu.name = produk_cu.name;
			},
			fetchCU(){
				if(this.modelCuStat != 'success'){
					this.$store.dispatch('cu/getHeader');
				}else{
					this.idCu = this.$route.params.cu;
					this.tingkat = this.$route.params.tingkat;
				}
			},
			fetchProdukCu(id){
				produkCuAPI.getPinjamanCu(id)
        .then((response) => {
					this.modelProdukCu = response.data.model;
          this.modelProdukCuStat = 'success';
        })
        .catch((error) => {
					this.modelProdukCu = error.response;
          this.modelProdukCuStat = 'fail';
				});
			},
			save(){
				this.$validator.validateAll('formPinjaman').then((result) => {
					if (result) {
						if(this.mode == 'edit'){
							this.$emit('editPinjaman',this.formPinjaman);
						}else{
							this.$emit('createPinjaman',this.formPinjaman);
						}
					}else{
						this.submited = true;
					}	
				});	
			},
			messageClose(){
				this.message.show = false;
			},
			tutup(){
				this.$emit('tutup');
			}
		},
		computed: {
			...mapGetters('auth',{
				currentUser: 'currentUser'
			}),
			...mapGetters('cu',{
				modelCU: 'headerDataS',
				modelCUStat: 'headerDataStatS',
				updateMessage: 'update',
				updateStat: 'updateStat'
			}),
		}
	}
</script>