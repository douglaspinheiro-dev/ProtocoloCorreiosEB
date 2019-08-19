export default class TipoCorrespondencia {
  constructor (obj = {}) {
    this.tipoCorrespondencia = obj.tipoCorrespondencia || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.valor = obj.valor || 0.00
  }

  setOptions (tiposCorrespondencias) {
    let optionsTipoCorrespondencia = []
    if (tiposCorrespondencias.length > 0) {
      tiposCorrespondencias.map(option => optionsTipoCorrespondencia.push(
        {
          label: `${option.descricao} - R$ ${option.valor} `,
          value: option.tipoCorrespondencia + '',
          valor: option.valor
        }
      ))
    } else {
      optionsTipoCorrespondencia = [{
        label: 'Sem registros cadastrados',
        value: ''
      }]
    }
    return optionsTipoCorrespondencia
  }
}
