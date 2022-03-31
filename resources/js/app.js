require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router'
import routes from './routes';
import store from './store/index'
import appVue from './components/App'
import Vue2TouchEvents from 'vue2-touch-events'
import VueDraggableResizable from 'vue-draggable-resizable'

Vue.component('vue-draggable-resizable', VueDraggableResizable)
Vue.component('payments-list', require('./components/PaymentsList.vue').default);
Vue.component('createorderwithdraw', require('./components/CreateOrderWithdraw.vue').default);
Vue.component('timeleft', require('./components/timeleft.vue').default);

Vue.use(VueRouter)
Vue.use(Vue2TouchEvents)

window.Vue = require('vue');

const app = new Vue({
    el: '#app-vue'
});

const newApp = new Vue({
    render: h => h(appVue),
    router: routes,
    store
}).$mount("#new-vue-app")
