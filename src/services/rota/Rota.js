export default class Rota {
  constructor (status = 1, descricao = '', codigo = '', rota = '', usuarioCriador = '') {
    this.rota = rota
    this.status = status
    this.descricao = descricao
    this.codigo = codigo
    this.usuarioCriador = usuarioCriador
  }
}
