export default class TipoDocumento {
  constructor (status = 1, descricao = '', codigo = '', tipoDocumento = '', usuarioCriador = '') {
    this.tipoDocumento = tipoDocumento
    this.status = status
    this.descricao = descricao
    this.codigo = codigo
    this.usuarioCriador = usuarioCriador
  }
}
