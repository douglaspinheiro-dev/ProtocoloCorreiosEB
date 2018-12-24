export default class ProtocoloEntrada {
  constructor (obj = {}) {
    this.protocoloEntrada = obj.protocoloEntrada || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.numero = obj.numero || ''
    this.assunto = obj.assunto || ''
    this.origem = obj.origem || ''
    this.setor = obj.setor || ''
    this.dataDocumento = obj.dataDocumento || ''
    this.enderecoCadastrado = obj.enderecoCadastrado || true
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
