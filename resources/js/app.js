require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router'
import routes from './routes';
import appVue from './components/App'

window.Vue = require('vue');

Vue.component('payments-list', require('./components/PaymentsList.vue').default);
Vue.component('createorderwithdraw', require('./components/CreateOrderWithdraw.vue').default);
Vue.component('timeleft', require('./components/timeleft.vue').default);

Vue.use(VueRouter)

const app = new Vue({
    el: '#app-vue'
});

const newApp = new Vue({
    render: h => h(appVue),
    router: routes
}).$mount("#new-vue-app")
