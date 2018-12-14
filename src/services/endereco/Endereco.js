export default class Estoque {
  constructor (obj = {}) {
    this.estoque = obj.estoque || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.logradouro = obj.logradouro || ''
    this.numero = obj.numero || ''
    this.complemento = obj.complemento || ''
    this.bairro = obj.bairro || ''
    this.cidade = obj.cidade || ''
    this.uf = obj.uf || ''
    this.cep = obj.cep || ''
    this.referencia = obj.referencia || ''
  }
}
