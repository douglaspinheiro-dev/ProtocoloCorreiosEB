export default class Endereco {
  constructor (obj = {}) {
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
