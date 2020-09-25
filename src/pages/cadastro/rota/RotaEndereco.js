export default class RotaEndereco {
  constructor (obj = {}) {
    this.rota = obj.rota || ''
    this.endereco = obj.endereco || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }

  setOptions (enderecos) {
    let optionsRotaEndereco = [{
      label: '-------',
      value: ''
    }]
    if (enderecos.length > 0) {
      enderecos.map(option => optionsRotaEndereco.push(
        {
          label: `${option.codigoReduzido} - ${option.descricao}`,
          value: option.rotaEndereco
        }
      ))
    } else {
      optionsRotaEndereco = [{
        label: 'Sem registros. Cadastre primeiro em Cadastro de Rotas > Endereços',
        value: ''
      }]
    }
    return optionsRotaEndereco
  }
}
