export default class MaloteDocumento {
  constructor (obj = {}) {
    this.malote = obj.malote || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.setor = obj.setor || ''
    this.numero = obj.numero || ''
    this.rotaEndereco = obj.rotaEndereco || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
