import axios from 'axios'
import router from '../router'
import store from '../store'

export const connection = axios.create(
  {
    baseURL: process.env.API,
    timeout: 180000,
    headers: {
      'Content-type': 'application/json'
    }
  }
)

connection.interceptors.response.use(function (response) {
  if (response.status === 203) {
    // se resposta for NÃO PERMITIDO retorna pro login
    console.log('nao permitido, vai pro login')
    store.dispatch('login/setSessaoInvalida', true)
    router.push('login')
    return
  }
  return response
}, function (error) {
  // Do something with response error
  console.log(error)
  return Promise.reject(error)
})

export default connection
