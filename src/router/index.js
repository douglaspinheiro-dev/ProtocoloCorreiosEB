import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import routes from './routes'

Vue.use(VueRouter)
const Event = new Vue()
const Router = new VueRouter({
  /*
   * NOTE! Change Vue Router mode from quasar.conf.js -> build -> vueRouterMode
   *
   * If you decide to go with "history" mode, please also set "build.publicPath"
   * to something other than an empty string.
   * Example: '/' instead of ''
   */

  // Leave as is and change from quasar.conf.js instead!
  mode: process.env.VUE_ROUTER_MODE,
  base: process.env.VUE_ROUTER_BASE,
  scrollBehavior: () => ({ y: 0 }),
  routes
})

Router.beforeEach((to, from, next) => {
  if (to.meta.requerAutenticacao) {
    // store.commit('menuRight/setBotaoListagemDeRegistros', to.meta.menuRight)
    // store.commit('menuRight/setListagemDeRegistros', to.meta.menuRight)

    // Events.$emit('resetInfinitScroll')

    if (store.getters['login/isLogged']) {
      console.log('estou logado')
      Event.$emit('toggleLeft')
      next()
    } else {
      console.log('mandei ir pro /')
      next('/')
    }
    return
  }
  console.log('nada a fazer')
  next()
})

export default Router
