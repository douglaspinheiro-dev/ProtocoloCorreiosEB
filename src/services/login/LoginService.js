import Service from 'src/services/Service'
class LoginService extends Service {
  static logar (usuario) {
    return this.post('/auth/login', usuario)
  }

  static deslogar (usuario) {
    return this.delete('/logoff', usuario)
  }

  static alteraEmpresaLogada (empresa) {
    return this.post('/alterarEmpresaLogada', {
      empresa: empresa
    })
  }

  static isLogged (token) {
    return this.post('/auth/logged', {
      token
    })
  }
}
export default LoginService
