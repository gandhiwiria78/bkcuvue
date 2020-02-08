<template>
    <form @submit.prevent="save" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">          
                <div class="col-md-4">   
                
                    <div class="form-group"> 
                        <!-- title -->
                        <h5 :class="{ 'text-danger' : errors.has('form.no_surat')}">
                          <i class="icon-cross2" v-if="errors.has('form.no_surat')"></i>
                                Pilih Pengelola Yang Mengajukan Surat
                        </h5>
                        <!-- Select Box get Data dari Vuex-->
                        <select class="form-control" name="id_pengelola" v-model="form.id_pengelola" data-width="100%" @change.prevent="selectItemP($event.target.value)" >
                            <option disabled value="">Silahkan pilih data</option>
                            <option v-for="pengelola in itemData.data" :value="pengelola.id" v-if="pengelola">{{ pengelola.name}}</option>
					    </select>
                    </div>  
                </div>
            </div>
        </div>
    </form>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
    props:{
       state: {
            default () {
                return ''
            },
       },
    },
    data(){
        return{
            kelas:'pengelola',
            query:{
                order_column:'nim',
                order_direction: "asc",
                filter_match: "and",
                limit: 50,
                page: 1
			},
            form:{
                no_surat:'',
                id_pengelola:'',
                kode:'',
            },
            selectItem:''
        }
    },
    created(){
        this.fecth(this.query);
    },
    methods:{
        fecth(params){    
           // this.$route.params.cu = 0;
           this.$store.dispatch(this.kelas + '/indexCu', [params,this.$route.params.cu]);
        },
        getPengelola(){

        },
        selectItemP(p){
            // console.log(
            this.$store.dispatch(this.kelas+'/editIdentitas',p)
            this.$emit('selectItemP');   
        },
        save(){

        }
    },
    computed:{
        ...mapGetters('auth',{
			currentUser: 'currentUser'
		}),
       ...mapGetters('pengelola',{
            itemData: 'dataS',
            itemDataStat: 'dataStatS',
		}),
    },
}
</script>

