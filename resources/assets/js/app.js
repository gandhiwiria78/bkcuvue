import Vue from 'vue';
import './helpers/filter.js';
import Api from './helpers/api.js';
import Admin from './admin.vue';
import VueRouter from 'vue-router';
import routes from './routes';
import store from './store';
import Axios from 'axios';
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
import { initialize } from './helpers/general';
import moment from 'moment';
import Vue2Filters from 'vue2-filters';
import VueKatex from 'vue-katex';
import VTooltip from 'v-tooltip';
import FileManager from 'laravel-file-manager';
import CKEditor from '@ckeditor/ckeditor5-vue';
import {VueEditor } from 'vue-quill2-editor';
import katex from 'katex';
import 'katex/dist/katex.min.css';




Validator.localize('id', id); //localization
Vue.use(VueRouter);
Vue.use(VeeValidate, {
  fieldsBagName: 'formFields'
});

Vue.use(Vue2Filters);
Vue.use(VueKatex);
Vue.use(VTooltip);
Vue.use( CKEditor);

//Vue.use(Quill);

//Vue.use(Quill);



Vue.component('vue-editor',VueEditor);

window.moment = moment; // handling date formating
window.moment.locale('id'); // handling date formating locale
window.axios = Axios; // handling http post
window.api = new Api(); // handling axios api
window.katex = katex;
//window.quill = Quill;

const router = new VueRouter({
  base: '/admins',
  mode: 'history',
  routes
});

Vue.use(FileManager, {store});
initialize(store, router);

export const bus = new Vue();

const app = new Vue({
  store,
  router,
  render: h => h(Admin)
}).$mount('#app');