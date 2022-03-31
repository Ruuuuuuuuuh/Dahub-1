import Vue from 'vue';
import Vuex from 'vuex';
import naviagation from './modules/naviagation'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        naviagation
    }
});
