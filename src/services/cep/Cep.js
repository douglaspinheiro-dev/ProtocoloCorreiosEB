export default class Cep {
  constructor (
    bairro = '',
    cep = '',
    cidade = '',
    logradouro = '',
    numero = '',
    uf = ''
  ) {
    this.bairro = bairro
    this.cep = cep
    this.cidade = cidade
    this.logradouro = logradouro
    this.numero = numero
    this.uf = uf
  }
}
