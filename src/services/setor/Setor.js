export default class Setor {
  constructor (obj = {}) {
    this.setor = obj.setor || ''
    this.status = obj.status || 1
    this.descricao = obj.descricao || ''
    this.codigo = obj.codigo || ''
    this.usuarioCriador = obj.usuarioCriador || ''
  }

  setOptions (setores) {
    let optionsSetor = [{
      label: '-------',
      value: ''
    }]
    if (setores.length > 0) {
      setores.map(option => optionsSetor.push(
        {
          label: `${option.codigoReduzido} - ${option.descricao}`,
          value: option.setor
        }
      ))
    } else {
      optionsSetor = [{
        label: 'Sem registros cadastrados',
        value: ''
      }]
    }
    return optionsSetor
  }
}
