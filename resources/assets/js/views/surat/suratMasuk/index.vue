<template>
    <div>
        <!-- page Header  -->
        <page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon" ></page-header>
        <!-- page container -->
		<div class="page-content pt-0">
			<div class="content-wrapper">
				<div class="content">
                    <div class="nav-tabs-responsive mb-3">
						<ul class="nav nav-tabs nav-tabs-solid bg-light">
							<li class="nav-item">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'suratMasuk'}" @click.prevent="changeTab('suratMasuk')" ><i class="icon-mail-read mr-2"></i> Tabel Surat Masuk</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'suratHapus'}" @click.prevent="changeTab('suratHapus')" ><i class="icon-cabinet mr-2"></i> Tabel Surat Hapus</a>
							</li>
						</ul>
					</div>
                     <transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-show="tabName == 'suratMasuk'" v-if="isSuratMasuk">
							<table-surat-masuk
                                :title="titleSuratMasuk"
                                :kelas="kelas"
                                :columnData="columnData2" >
							</table-surat-masuk>
						</div>
					</transition>
                    <transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-show="tabName == 'suratHapus'" v-if="isSuratHapus">
							<table-only-trance
                                :title="titleSuratTrash"
                                :kelas="kelas"
                                :columnData="columnData2" >
                            </table-only-trance>
						</div>
					</transition>
				</div>
			</div>
		</div>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import pageHeader from '../../../components/pageHeader.vue';
    import tableSuratMasuk from './tableSuratMasuk' ;
    import tableOnlyTrance from './tableOnlyTrance.vue'
    
    export default {
        components: {   
            pageHeader,
            tableOnlyTrance,
            tableSuratMasuk,
        },
        data() {
            return {
                title: 'Surat ',
                titleSuratMasuk:"Surat Masuk",
                titleSuratTrash:'Surat Sampah',
                kelas: 'surat',
                titleDesc: 'Mengelola Surat Masuk',
                titleIcon: 'icon-mail-read',
                tabName: 'suratMasuk',
                isSuratMasuk: true,
                isSuratHapus: true,
            }
        },
        methods:{
            changeTab(e){
                this.tabName = e ; 
                if(e == 'suratMasuk' && !this.isSuratMasuk){
                    this.isSuratMasuk = true ;
                }else if(e == 'suratHapus'){
                    this.isSuratHapus = true;
                }
            }
        },
        computed:{
            ...mapGetters ('surat',{
                itemData:'dataS',
                itemDataStat:'dataStatS',
                itemDatas:'dataS2',
                itemDataStats:'dataStats2',
                columnData:'columnData',
                columnData2:'columnData2'
            })
        }
    }
</script>

