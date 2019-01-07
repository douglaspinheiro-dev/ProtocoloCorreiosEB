export default class TipoCorrespondencia {
  constructor (obj = {}) {
    this.tipoCorrespondencia = obj.tipoCorrespondencia || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.valor = obj.valor || 0.00
  }
}
