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
								<a href="#" class="nav-link" :class="{'active' : tabName == 'suratKeluar'}" @click.prevent="changeTab('suratKeluar')" ><i class="icon-mail-read mr-2"></i> Tabel Surat Masuk</a>
							</li>
                            <li class="nav-item">
								<a href="#" class="nav-link" :class="{'active' : tabName == 'suratHapus'}" @click.prevent="changeTab('suratHapus')" ><i class="icon-cabinet"></i> Tabel Surat Hapus</a>
							</li>
						</ul>
					</div>
                     <transition enter-active-class="animated fadeIn" mode="out-in">

						<div v-show="tabName == 'suratKeluar'" >
                           
							<table-surat-keluar
                                :title="titleSuratKeluar"
                                :kelas="kelas"
                                :columnData="columnData" >
							</table-surat-keluar>
						</div>
					</transition>
                    <transition enter-active-class="animated fadeIn" mode="out-in">
						<div v-show="tabName == 'suratHapus'">
							<table-only-trance
                                :title="titleSuratKeluar"
                                :kelas="kelas"
                                :columnData="columnData"
                            >

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
    import tableSuratKeluar from './tableSuratKeluar';
    import tableOnlyTrance from './tableOnlyTrance.vue';
    
    export default {
        components: {   
            pageHeader,
            tableSuratKeluar,
            tableOnlyTrance
        },
        data() {
            return {
                title: 'Surat ',
                titleSuratKeluar:'Surat Keluar',
                kelas: 'surat',
                titleDesc: 'Mengelola Surat Keluar',
                titleIcon: 'icon-stats-bars2',
                tabName: 'suratKeluar',
                isSuratKeluar:true,
                isSuratHapus:true,
            }
        },
        methods:{
            changeTab(e){
                this.tabName = e ; 
                if(e == 'suratKeluar' && !this.isSuratKeluar){
                    this.isSuratKeluar = true ;
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

