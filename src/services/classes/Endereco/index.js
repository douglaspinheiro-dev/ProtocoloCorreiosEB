export default class Endereco {
  constructor (
    bairro = '',
    cep = '',
    cidade = '',
    complemento = '',
    logradouro = '',
    numero = '',
    referencia = '',
    uf = ''
  ) {
    this.bairro = bairro
    this.cep = cep
    this.cidade = cidade
    this.complemento = complemento
    this.logradouro = logradouro
    this.numero = numero
    this.referencia = referencia
    this.uf = uf
  }
}
