import dayjs from 'dayjs'

export default class BuscaProtocoloEntrada {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
    this.origem = obj.origem || ''
    this.setor = obj.setor || ''
    this.assunto = obj.assunto || ''
    this.numero = obj.numero || ''
    this.dataDocumento = obj.dataDocumento || dayjs().format('YYYY-MM-DD')
    this.tipoData = obj.tipoData || 'data'
    this.dataInicial = obj.dataInicial || dayjs().startOf('month').format('YYYY-MM-DD')
    this.dataFinal = obj.dataFinal || dayjs().endOf('month').format('YYYY-MM-DD')
    this.mesCadastro = obj.mesCadastro || dayjs().format('YYYY-MM')
    this.protocolo = obj.protocolo || ''
  }
}
