require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue');

Vue.component('payments-list', require('./components/PaymentsList.vue').default);
Vue.component('createorderwithdraw', require('./components/CreateOrderWithdraw.vue').default);
Vue.component('timeleft', require('./components/timeleft.vue').default);

const app = new Vue({
    el: '#app-vue'
});
