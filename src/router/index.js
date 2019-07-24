import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import routes from './routes'
import storage from 'localforage'
import loginService from 'src/services/login/LoginService'

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
  // gambi para extensao
  let query = location.search.slice(1)
  let partes = query.split('&')
  let data = {}
  partes.forEach(parte => {
    let chaveValor = parte.split('=')
    let chave = chaveValor[0]
    let valor = chaveValor[1]
    data[chave] = valor
  })
  if (data.modo === 'extensao' && !store.getters['login/isLogged']) {
    // faz login como extensao
    loginService.logar({
      login: 'web',
      password: 'web54321'
    })
      .then(result => {
        if (result.status === 200) {
          // confirma token
          store.commit('login/setToken', result.data.token)
          store.commit('login/setLogin', { login: 'web', id: result.data.id, categoriaUsuario: result.data.categoriaUsuario })
          store.commit('login/setSessaoInvalida', false)
          store.commit('login/setAuth', result.data.token)
          store.commit('login/setPermissoes', result.data.permissoes)
          next('/protocoloentradas/extensao')
          // Event.$emit('toggleLeft')
        }
      })
    // abre protocoloEntrada extensao
    return
  }
  // gambi
  if (to.meta.requerAutenticacao) {
    // store.commit('menuRight/setBotaoListagemDeRegistros', to.meta.menuRight)
    // store.commit('menuRight/setListagemDeRegistros', to.meta.menuRight)
    // Events.$emit('resetInfinitScroll')
    storage.getItem('token').then(function (token) {
      // This code runs once the token has been loaded
      // from the offline store.
      console.log('token', token)

      if (!store.getters['login/isLogged']) {
        console.log('nao esta logado')

        // se eu acabei de carregar o sistema e nao loguei, conferir se estava logado antes
        if (token !== null) {
          console.log('token nao é nulo')

          //  confere na rota se token é valido, se for,
          loginService.isLogged(token)
            .then(result => {
              if (result.status === 200) {
                // loga, altera o store e retorna a pagina anterior
                store.commit('login/setToken', result.data.token)
                store.commit('login/setLogin', { login: result.data.login, id: result.data.id, categoriaUsuario: result.data.categoriaUsuario })
                store.commit('login/setSessaoInvalida', false)
                store.commit('login/setAuth', result.data.token)
                store.commit('login/setPermissoes', result.data.permissoes)
                next()
              } else {
                store.commit('login/removeToken')
                next('/')
              }
            })
        } else {
          store.commit('login/removeToken')
          next('/')
        }
      } else {
        Event.$emit('toggleLeft')
        next()
      }
    }).catch(function (err) {
      // This code runs if there were any errors
      console.log(err)
    })
    return
  }
  console.log('nada a fazer')
  // storage.setItem('historico', to.path)
  next()
})

export default Router
