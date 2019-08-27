import Service from 'src/services/Service'
class RecuperarSenhaService extends Service {
  static enviarCodigoEmail (login) {
    return this.post('recuperar/login', login)
  }

  static confirmarToken (token) {
    return this.post('recuperar/token', token)
  }

  static confirmarTokenLogin (token) {
    return this.post('clientes/twa/confirmar', token)
  }

  static confirmarTokenTwa (token) {
    return this.post('clientes/twa/token', token)
  }

  static alterarSenha (dados) {
    return this.put('recuperar/alterarsenha', dados)
  }
}
export default RecuperarSenhaService
