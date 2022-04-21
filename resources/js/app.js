require('./bootstrap');
import Vue from 'vue';
import store from './store/index'
import Vue2TouchEvents from 'vue2-touch-events'
import VueDraggableResizable from 'vue-draggable-resizable'

Vue.component('vue-draggable-resizable', VueDraggableResizable)
Vue.component('payments-list', require('./components/PaymentsList.vue').default);
Vue.component('payments-screen', require('./screens/PaymentsScreen.vue').default);
Vue.component('createorderwithdraw', require('./components/CreateOrderWithdraw.vue').default);
Vue.component('timeleft', require('./components/timeleft.vue').default);
Vue.component('app', require('./components/App').default);

Vue.use(Vue2TouchEvents)

window.Vue = require('vue');


if(document.querySelector('#app-vue')) {
const app = new Vue({
    store,
    el: '#app-vue'
});
}

