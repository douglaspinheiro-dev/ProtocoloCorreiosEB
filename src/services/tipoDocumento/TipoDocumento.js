export default class TipoDocumento {
  constructor (status = 1, descricao = '', tipoDocumento = '', usuarioCriador = '') {
    this.tipoDocumento = tipoDocumento
    this.status = status
    this.descricao = descricao
    this.usuarioCriador = usuarioCriador
  }
}
