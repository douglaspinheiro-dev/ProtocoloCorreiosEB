import http from 'src/plugins/axios'
import MsgDialog from '../../tools/Dialogs'
import { Dialog } from 'quasar'

export const RecuperarSenhaService = {
  enviarCodigoEmail (login) {
    return http.post('recuperar/login', login)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao enviar email ao usuario, para recuperar senha', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  },

  confirmarToken (token) {
    return http.post('recuperar/token', token)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao confirmar token do usuario, para recuperar senha', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  },

  confirmarTokenLogin (token) {
    return http.post('clientes/twa/confirmar', token)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao confirmar token do usuario, para logar', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  },

  confirmarTokenTwa (token) {
    return http.post('clientes/twa/token', token)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao confirmar token do usuario, para ativar twa', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  },

  alterarSenha (dados) {
    return http.put('recuperar/alterarsenha', dados)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao alterar a senha do usuario, no recuperar senha', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  }
}
export default RecuperarSenhaService
