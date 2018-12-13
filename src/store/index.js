import Vue from 'vue'
import Vuex from 'vuex'

import login from './login'
import menuRight from './menuRight'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    login,
    menuRight
  }
})

export default store
