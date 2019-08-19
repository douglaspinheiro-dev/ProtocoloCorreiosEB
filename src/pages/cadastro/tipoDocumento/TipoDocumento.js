export default class TipoDocumento {
  constructor (obj = {}) {
    this.tipoDocumento = obj.tipoDocumento || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }

  setOptions (tipoDocumentos) {
    let optionsTipoDocumento = [{
      label: '-------',
      value: ''
    }]
    if (tipoDocumentos.length > 0) {
      tipoDocumentos.map(option => optionsTipoDocumento.push(
        {
          label: option.descricao,
          value: option.tipoDocumento
        }
      ))
    } else {
      optionsTipoDocumento = [{
        label: 'Sem registros cadastrados',
        value: ''
      }]
    }
    return optionsTipoDocumento
  }
}
