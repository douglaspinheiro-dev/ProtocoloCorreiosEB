import Service from 'src/services/Service'

class BuscaMaloteService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('busca-malotes', {
      params: {
        busca
      }
    })
  }

  static procuraDocumento (dados) {
    return this.get('busca-malotes/documento', {
      params: dados
    })
  }

  static procuraMes (dados) {
    return this.get('busca-malotes/mes', {
      params: dados
    })
  }

  static relatorio (dados) {
    return this.get('busca-malotes/relatorio', {
      params: dados
    })
  }

  static relatorioConsolidadoPorMes (dados) {
    return this.get('busca-malotes/relatorio-por-mes', {
      params: dados
    })
  }

  static seleciona (obj) {
    return this.get(`busca-malotes/protocolo/${obj.protocolo}/ano/${obj.ano}`)
  }

  static getOptions () {
    return this.get(`busca-malotes/options`)
  }
}
export default BuscaMaloteService
