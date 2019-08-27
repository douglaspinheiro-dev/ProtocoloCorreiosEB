import Service from 'src/services/Service'
class BuscaCorrespondenciaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('busca-correspondencias', {
      params: {
        busca
      }
    })
  }

  static procuraDocumento (dados) {
    return this.get('busca-correspondencias/correspondencia', {
      params: dados
    })
  }

  static procuraDocumentoPublico (dados) {
    return this.get('busca-correspondencias/correspondencia/publico', {
      params: dados
    })
  }

  static relatorio (dados) {
    return this.get('busca-correspondencias/relatorio', {
      params: dados
    })
  }

  static relatorioPublico (dados) {
    return this.get('busca-correspondencias/relatorio/publico', {
      params: dados
    })
  }

  static seleciona (obj) {
    return this.get(`busca-correspondencias/protocolo/${obj.protocolo}/ano/${obj.ano}`)
  }

  static getOptions () {
    return this.get(`busca-correspondencias/options`)
  }
  static getOptionsPublico () {
    return this.get(`busca-correspondencias/options/publico`)
  }
}
export default BuscaCorrespondenciaService
