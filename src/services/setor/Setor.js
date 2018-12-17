export default class Setor {
  constructor (obj = {}) {
    this.setor = obj.setor || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
