export default class Rota {
  constructor (obj = {}) {
    this.rota = obj.rota || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }

  setOptions (rotas) {
    console.log('rotas', rotas)
    let optionsRota = []
    if (rotas.length > 0) {
      rotas.map(option => optionsRota.push(
        {
          label: option.descricao,
          value: option.rota
        }
      ))
    } else {
      optionsRota = [{
        label: 'Sem registros. Cadastre primeiro em Cadastro de Rotas',
        value: ''
      }]
    }
    return optionsRota
  }
}
