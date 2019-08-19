export default class Usuario {
  constructor (obj = {}) {
    this.usuario = obj.usuario || ''
    this.nome = obj.nome || ''
    this.login = obj.login || ''
    this.grupoUsuario = obj.grupoUsuario || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
