import Vue from 'vue'
import Vuex from 'vuex'

import login from './login'
import menuRight from './menuRight'
import listaDeRegistros from './listaDeRegistros'
import tabs from './tabs'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    login,
    menuRight,
    listaDeRegistros,
    tabs
  }
})

export default store
