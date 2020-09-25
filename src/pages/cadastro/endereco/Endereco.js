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
    this.malote = obj.malote || false
    this.rota = obj.rota || ''
  }

  setOptions (enderecos) {
    let optionsEndereco = []
    if (enderecos.length > 0) {
      enderecos.map(option => optionsEndereco.push(
        {
          label: `${option.codigoReduzido} - ${option.descricao}`,
          value: option.codigoReduzido,
          logradouro: option.logradouro,
          numero: option.numero,
          complemento: option.complemento,
          bairro: option.bairro,
          cidade: option.cidade,
          uf: option.uf,
          cep: option.cep,
          referencia: option.referencia

        }
      ))
    } else {
      optionsEndereco = [{
        label: 'Sem registros. Cadastre primeiro em Cadastro de Endereços',
        value: ''
      }]
    }
    return optionsEndereco
  }
}
