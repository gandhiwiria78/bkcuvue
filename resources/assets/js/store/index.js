import Vue from 'vue';
import Vuex from 'vuex';

import { auth } from './modules/auth';
import { user } from './modules/user';
import { role } from './modules/role';
import { global } from './modules/global';
import { artikel } from './modules/artikel';
import { artikelKategori } from './modules/artikelKategori';
import { artikelPenulis } from './modules/artikelPenulis';
import { pengumuman } from './modules/pengumuman';
import { cu } from './modules/cu';
import { tp } from './modules/tp';
import { pus } from './modules/pus';
import { provinces } from './modules/provinces';
import { regencies } from './modules/regencies';
import { districts } from './modules/districts';
import { villages } from './modules/villages';
import { laporanCu } from './modules/laporanCu';
import { laporanCuDiskusi } from './modules/laporanCuDiskusi';
import { laporanTp } from './modules/laporanTp';
import { aktivis } from './modules/aktivis';
import { mitraOrang } from './modules/mitraOrang';
import { mitraLembaga } from './modules/mitraLembaga';
import { anggotaCu } from './modules/anggotaCu';
import { produkCu } from './modules/produkCu';
import { diklatBKCU } from './modules/diklatBKCU';
import { tempat } from './modules/tempat';
<<<<<<< HEAD
import { notification } from './modules/notification';
import { saran } from './modules/saran';
import { errorLog } from './modules/errorLog';
=======
import { surat } from './modules/surat';
import { files } from './modules/files';
>>>>>>> 667744084973553ef57d0dec9ac0e5e1ef8bd54e

Vue.use(Vuex);

export default new Vuex.Store({
	 modules: {
		 global,
		 auth,
		 user,
		 role,
		 artikel,
		 artikelKategori,
		 artikelPenulis,
		 pengumuman,
		 cu,
		 tp,
		 pus,
		 provinces,
		 regencies,
		 districts,
		 villages,
		 laporanCu,
		 laporanCuDiskusi,
		 laporanTp,
		 aktivis,
		 mitraOrang,
		 mitraLembaga,
		 anggotaCu,
		 produkCu,
		 diklatBKCU,
		 tempat,
<<<<<<< HEAD
		 notification,
		 saran,
		 errorLog
=======
		 surat,
		 files
>>>>>>> 667744084973553ef57d0dec9ac0e5e1ef8bd54e
	 }
});