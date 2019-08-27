import Service from 'src/services/Service'
class MaloteDocumentoService extends Service {
  // usado para a lista de registros
  static procura (busca, inicio, fim) {
    return this.get('malotedocumentos', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  // usado para preencher selects
  static lista (id) {
    return this.get(`malotedocumentos/malote/${id}`)
  }

  static seleciona (documento) {
    return this.get(`malotedocumentos/malotedocumento/${documento}`)
  }

  static grava (maloteDocumento) {
    return this.post(`malotedocumentos/malotedocumento`, maloteDocumento)
  }

  static altera (maloteDocumento) {
    return this.put(`malotedocumentos/malotedocumento/${maloteDocumento.maloteDocumento}`, maloteDocumento)
  }

  static apaga (obj) {
    console.log(obj)
    return this.delete(`malotedocumentos/malotedocumento/${obj}`)
  }
  static getOptions (rota) {
    return this.get(`malotedocumentos/options/${rota}`)
  }
}
export default MaloteDocumentoService
