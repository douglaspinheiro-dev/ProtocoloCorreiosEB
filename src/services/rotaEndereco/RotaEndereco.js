export default class RotaEndereco {
  constructor (obj = {}) {
    this.rota = obj.rota || ''
    this.endereco = obj.endereco || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }
}
