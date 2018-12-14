export default class TipoCorrespondencia {
  constructor (status = 1, descricao = '', tipoCorrespondencia = '', usuarioCriador = '') {
    this.tipoCorrespondencia = tipoCorrespondencia
    this.status = status
    this.descricao = descricao
    this.usuarioCriador = usuarioCriador
  }
}
