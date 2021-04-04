import Service from 'src/services/Service'
class TipoDocumentoService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('tipodocumentos', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (tipodocumento) {
    return this.post('tipodocumentos/tipodocumento', tipodocumento)
  }

  static altera (tipoDocumento) {
    return this.put(`tipodocumentos/tipodocumento/${tipoDocumento.tipoDocumento}`, tipoDocumento)
  }

  static apaga (id) {
    return this.delete(`tipodocumentos/tipodocumento/${id}`)
  }

  static seleciona (id) {
    return this.get(`tipodocumentos/tipodocumento/${id}`)
  }
}
export default TipoDocumentoService
