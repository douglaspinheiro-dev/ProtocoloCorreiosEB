import dayjs from 'dayjs'
export default class Correspondencia {
  constructor (obj = {}) {
    this.correspondencia = obj.correspondencia || ''
    this.protocolo = obj.protocolo || ''
    this.anoCadastro = obj.anoCadastro || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.numero = obj.numero || ''
    this.setor = obj.setor || ''
    this.destino = obj.destino || ''
    this.enderecoCadastrado = obj.enderecoCadastrado || false
    this.usuarioCriador = obj.usuarioCriador || ''
    this.tipoCorrespondencia = obj.tipoCorrespondencia || ''
    this.tipoCobranca = obj.tipoCobranca || ''
    this.valorTC = obj.valorTC || ''
    this.valorTotal = obj.valorTotal || 0.00
    this.dataCadastro = obj.dataCadastro || dayjs().format('YYYY-MM-DD')
  }
}
