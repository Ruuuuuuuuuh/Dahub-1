/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */



 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */


 import Vue from 'vue'
 import VueRouter from 'vue-router'
 import App from './components/App.vue'

 Vue.use(VueRouter)

 import Router from './routes';

 import Vuetify from 'vuetify'

 import 'vuetify/dist/vuetify.min.css'

 import Vuex from 'vuex';


 Vue.use(Vuetify)

 Vue.use(Vuex)

/* new Vue({
     Router,
     render: (h) => h(App)
 )}.$mount('#app');x */


