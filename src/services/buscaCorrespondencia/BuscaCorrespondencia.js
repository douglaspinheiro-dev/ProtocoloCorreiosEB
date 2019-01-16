import dayjs from 'dayjs'

export default class BuscaCorrespondencia {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
    this.destino = obj.destino || ''
    this.setor = obj.setor || ''
    this.numero = obj.numero || ''
    this.cep = obj.cep || ''
    this.estado = obj.estado || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.tipoCobranca = obj.tipoCobranca || ''
    this.codigoRastreio = obj.codigoRastreio || ''
    this.dataCadastro = obj.dataCadastro || ''
    this.tipoData = obj.tipoData || 'periodo'
    this.dataInicial = obj.dataInicial || ''
    this.dataFinal = obj.dataFinal || ''
    this.mesCadastro = obj.mesCadastro || ''
    this.protocolo = obj.protocolo || ''
  }
}
