
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('edit', require('./components/edit.vue').default);
Vue.component('create', require('./components/create.vue').default);
Vue.component('index', require('./components/index.vue').default);

// Vue.component('pagination', Pagination);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *
 */
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';

import pagination from "vuejs-uib-pagination";


Vue.use(pagination);

Vue.use(VueAxios, axios);

const app1 = new Vue({
    el: '#app1',
});
