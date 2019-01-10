import dayjs from 'dayjs'

export default class BuscaProtocoloEntrada {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
    this.dataDocumento = obj.dataDocumento || ''
    this.origem = obj.origem || ''
    this.setor = obj.setor || ''
    this.assunto = obj.assunto || ''
    this.numero = obj.numero || ''
  }
}
