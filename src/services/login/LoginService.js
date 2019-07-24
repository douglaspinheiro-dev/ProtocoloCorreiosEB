import http from 'src/plugins/axios'
import MsgDialog from '../../tools/Dialogs'

export const LoginService = {
  logar (usuario) {
    return http.post('/auth/login', usuario)
      .then(response => response)
      .catch(error => {
        MsgDialog(error.response)
        throw new Error(error)
      })
  },

  deslogar (usuario) {
    return http.delete('/logoff', usuario)
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao fazer logout', error)
        MsgDialog(error)
        throw new Error(error)
      })
  },

  alteraEmpresaLogada (empresa) {
    return http.post('/alterarEmpresaLogada', {empresa: empresa})
      .then(response => response)
      .catch(error => {
        console.log('Erro no servidor ao trocar empresa logada', error)
        MsgDialog(error)
        throw new Error(error)
      })
  },

  isLogged (token) {
    return http.post('/auth/logged', {token})
      .then(response => response)
      .catch(error => {
        console.log('Erro ao validar token', error)
        MsgDialog(error)
        throw new Error(error)
      })
  }
}
export default LoginService
