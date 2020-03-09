<template>
   <div>
    <data-viewer :title="title" :columnData="columnData" :itemData="itemDatas" :query="query" :itemDataStat="itemDataStats" :excelUrl="excelUrl" :isUploadExcel="false" @fetch="fetch">
        <!-- button desktop -->
        <template slot="button-desktop">
            <button @click.prevent="tambahSurat"  class="btn btn-light mb-1" >
                <i class="icon-plus3"></i> Tambah Surat Masuk
            </button>
                <button @click.prevent="ubahData(selectedItem.id)"  class="btn btn-light mb-1"  :disabled="!selectedItem.id">
                <i class="icon-pencil5"></i> Edit 
            </button>
            <button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light mb-1"  :disabled="!selectedItem.id">
                <i class="icon-bin2"></i> Hapus
            </button>
        </template>
        <!-- button mobile -->
        <template slot="button-mobile">
            <button @click.prevent="tambahSurat" class="btn btn-light btn-block mb-1" >
                <i class="icon-plus3"></i> Tambah Nomor Surat
            </button>
            <button @click.prevent="ubahData(selectedItem.id)" class="btn btn-light btn-block mb-1"  :disabled="!selectedItem.id">
                <i class="icon-pencil5"></i> Edit
            </button>
            <button @click.prevent="modalConfirmOpen('hapus')" class="btn btn-light btn-block mb-1"  :disabled="!selectedItem.id">
                <i class="icon-bin2"></i> Hapus
            </button>
        </template>
        <!-- Tabel Show -->
        <template slot="item-desktop" slot-scope="props">
				<tr :class="{ 'bg-info': selectedItem.id == props.item.id }" @click="selectedRow(props.item)" class="text-nowrap">
					<td v-if="!columnData[0].hide">
						{{ props.index + 1 + (+itemDatas.current_page-1) * +itemDatas.per_page + '.'}}
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
        <!-- modal -->
        <app-modal :show="modalShow" :state="modalState" :title="modalTitle" :button="modalButton" @tutup="modalTutup" @confirmOk="modalConfirmOk" @successOk="modalTutup" @failOk="modalTutup" @backgroundClick="modalTutup">
        </app-modal>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import DataViewer from '../../../components/dataviewer2.vue';
    import checkValue from '../../../components/checkValue.vue';
    import collapseButton from '../../../components/collapseButton.vue';
    import appModal from '../../../components/modal';
    
    export default{
        components:{
            DataViewer,
            checkValue,
            collapseButton,
            appModal
        },
        props:['title','kelas','columnData'],
        data(){
            return {
                query:{
                    order_column :'kode',
                    order_direction : 'desc',
                    filter_match: 'and',
                    limit: 10 ,
                    page: 1  
                },
                kode:'',
                selectedItem:[],
                excelUrl:'',
                title2: 'Surat Masuk',
                state:'',
                modalShow: false,
                modalState: '',
                modalTitle: '',
                modalColor: '',
                modalContent: '',
                modalButton:'',
            }
        },
        watch:{
            itemDatas(e){
                 
            }
        },
        created() {
            this.fetch(this.query);
        },
        methods:{
            fetch(params){ 
				this.$store.dispatch(this.kelas + '/indexSuratMasuk', params);
				this.excelUrl = this.kelas;
                // console.log('item',this.columnData2);
            },
            tambahSurat(){
                this.$router.push({name: this.kelas + 'masukCreate'});
            },
            ubahData(item){
                this.$router.push({name: this.kelas + 'masukEdit', params: { id: item}})
            },
            selectedRow(item){
                this.selectedItem = item;
            },
            
            modalConfirmOpen(state){
              
                this.modalShow = true;
                this.modalState = 'confirm-tutup';
                this.state = state;
                if( state =='hapus'){
                    this.modalTitle = 'Hapus Data Surat Nomor Surat '+ this.itemDatas.data[0].kode;
                    this.modalButton = 'Ya, Hapus';
                } 
            
            },
            modalTutup() {
                this.modalShow=false;
                if(this.state=='hapus'){
                    this.fetch(this.query);
                }
			},
            modalConfirmOk(){
                console.log('kkkk',this.kelas);
                if(this.state == 'hapus'){
                    this.$store.dispatch(this.kelas+'/softDestroySuratMasuk',this.selectedItem.id);
                }else{
                    
                }
                this.modalTutup();
            },
        },
        computed:{
            ... mapGetters('surat',{
                itemDatas:'dataS2',
                itemDataStats:'dataStats2',
               
            }),
        },
    }
    
</script>
