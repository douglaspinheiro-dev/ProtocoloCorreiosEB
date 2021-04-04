import http from 'src/boot/axios'
import { Dialog, Loading } from 'quasar'
import Notify from 'src/tools/notify'
import tools from '../tools/index'
const notificaErro = (error, rota) => {
  console.log(error)

  Loading.hide()
  if (error.response.status === 401) {
    tools.Notify.semPermissao()
  } else {
    Dialog.create({
      title: 'Atenção',
      message: 'Alguma coisa deu errado, contate o suporte e informe o erro:'
    })
    console.warn('Rota :', rota)
    console.warn(error.response.data)
  }
  throw new Error(error)
}

class Service {
  constructor () {
    this.Dialog = Dialog
    this.Loading = Loading
    this.Notify = Notify
  }

  static get (rota, params) {
    return http.get(rota, params)
      .then(response => response)
      .catch(error => notificaErro(error, rota))
  }

  static delete (rota, params) {
    return http.delete(rota, params)
      .then(response => response)
      .catch(error => notificaErro(error, rota))
  }

  static post (rota, body) {
    return http.post(rota, body)
      .then(response => response)
      .catch(error => notificaErro(error, rota))
  }

  static put (rota, body) {
    return http.put(rota, body)
      .then(response => response)
      .catch(error => notificaErro(error, rota))
  }
}
export default Service
