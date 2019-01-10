import dayjs from 'dayjs'

export default class BuscaProtocoloEntrada {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
  }
}
