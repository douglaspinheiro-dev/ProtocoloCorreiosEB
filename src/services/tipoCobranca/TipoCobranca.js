export default class TipoCobranca {
  constructor (obj = {}) {
    this.tipoCobranca = obj.tipoCobranca || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.valor = obj.valor || 0.00
  }
}
