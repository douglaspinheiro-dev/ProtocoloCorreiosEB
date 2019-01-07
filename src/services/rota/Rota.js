export default class Rota {
  constructor (obj = {}) {
    this.rota = obj.rota || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
