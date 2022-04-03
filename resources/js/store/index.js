import Vue from 'vue';
import Vuex from 'vuex';
import naviagation from './modules/naviagation'
import user from './modules/user'
import balances from './modules/balances'
import orders from './modules/orders'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        naviagation,
        user,
        balances,
        orders
    }
});
