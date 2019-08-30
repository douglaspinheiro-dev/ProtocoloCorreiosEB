import Vue from 'vue'
import Vuex from 'vuex'

import login from './login'
import menuRight from './menuRight'
import listaDeRegistros from './listaDeRegistros'
import tabs from './tabs'
import modalPdf from './modalPdf'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    login,
    menuRight,
    listaDeRegistros,
    tabs,
    modalPdf
  }
})

export default store
