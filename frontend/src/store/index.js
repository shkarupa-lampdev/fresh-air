import Vue from 'vue'
import Vuex from 'vuex'
import AuthStore from "@/store/auth.js";
import AlertStore from '@/store/alert.js'



Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        AuthStore,
        AlertStore
    }
})

export default store
