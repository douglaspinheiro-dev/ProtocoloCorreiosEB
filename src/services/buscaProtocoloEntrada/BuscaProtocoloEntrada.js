import dayjs from 'dayjs'

export default class BuscaProtocoloEntrada {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
    this.origem = obj.origem || ''
    this.setor = obj.setor || ''
    this.assunto = obj.assunto || ''
    this.numero = obj.numero || ''
    this.dataDocumento = obj.dataDocumento || ''
    this.tipoData = obj.tipoData || 'data'
    this.dataInicial = obj.dataInicial || null
    this.dataFinal = obj.dataFinal || null
    this.mesCadastro = obj.mesCadastro || null
  }
}
