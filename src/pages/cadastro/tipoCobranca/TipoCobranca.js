export default class TipoCobranca {
  constructor (obj = {}) {
    this.tipoCobranca = obj.tipoCobranca || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.valor = obj.valor || 0.00
  }

  setOptions (tiposCobrancas) {
    let optionsTipoCobranca = []
    if (tiposCobrancas.length > 0) {
      optionsTipoCobranca.push(
        {
          label: '-------',
          value: '',
          valor: 0.00
        }
      )
      tiposCobrancas.map(option => optionsTipoCobranca.push(
        {
          label: `${option.descricao} - R$ ${option.valor} `,
          value: option.tipoCobranca + '',
          valor: option.valor
        }
      ))
    } else {
      optionsTipoCobranca = [{
        label: 'Sem registros. Cadastre primeiro em Cadastro de Tipos de Cobranças',
        value: null
      }]
    }
    return optionsTipoCobranca
  }
}
