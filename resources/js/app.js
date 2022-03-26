require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue');

Vue.component('payments-list', require('./components/PaymentsList.vue').default);

const app = new Vue({
    el: '#app-vue'
});
