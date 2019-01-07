export default class Malote {
  constructor (obj = {}) {
    this.malote = obj.malote || ''
    this.data = obj.data || ''
    this.lacre = obj.lacre || ''
    this.numeroBolsa = obj.numeroBolsa || ''
    this.rota = obj.rota || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
