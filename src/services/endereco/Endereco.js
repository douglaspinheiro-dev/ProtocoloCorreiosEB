export default class Endereco {
  constructor (obj = {}) {
    this.endereco = obj.endereco || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
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
