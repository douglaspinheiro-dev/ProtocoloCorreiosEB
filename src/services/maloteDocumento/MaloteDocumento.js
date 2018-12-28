export default class MaloteDocumento {
  constructor (
    malote = '',
    tipoDocumento = '',
    setor = '',
    numero = '',
    rotaEndereco = '',
    usuarioCriador = ''
  ) {
    this.malote = malote
    this.tipoDocumento = tipoDocumento
    this.setor = setor
    this.numero = numero
    this.rotaEndereco = rotaEndereco
    this.usuarioCriador = usuarioCriador
  }
}
