export default class Usuario {
  constructor (nome = '', login = '', grupoUsuario = '', usuario = '', usuarioCriador = '') {
    this.usuario = usuario
    this.nome = nome
    this.login = login
    this.grupoUsuario = grupoUsuario
    this.usuarioCriador = usuarioCriador
  }
}
