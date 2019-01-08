import dayjs from 'dayjs'
export default class Correspondencia {
  constructor (obj = {}) {
    this.correspondencia = obj.correspondencia || ''
    this.protocolo = obj.protocolo || ''
    this.anoCadastro = obj.anoCadastro || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.numeroDocumento = obj.numeroDocumento || ''
    this.setor = obj.setor || ''
    this.remetente = obj.remetente || ''
    this.destino = obj.destino || ''
    this.enderecoCadastrado = obj.enderecoCadastrado || false
    this.usuarioCriador = obj.usuarioCriador || ''
    this.tipoCorrespondencia = obj.tipoCorrespondencia || ''
    this.tipoCobranca = obj.tipoCobranca || ''
    this.valorTC = obj.valorTC || ''
    this.codigoRastreio = obj.codigoRastreio || ''
    this.valorTotal = obj.valorTotal || 0.00
    this.dataCadastro = obj.dataCadastro || dayjs().format('YYYY-MM-DD')

    this.bairro = obj.bairro || ''
    this.cep = obj.cep || ''
    this.cidade = obj.cidade || ''
    this.complemento = obj.complemento || ''
    this.logradouro = obj.logradouro || ''
    this.numero = obj.numero || ''
    this.referencia = obj.referencia || ''
    this.uf = obj.uf || ''
  }
}
