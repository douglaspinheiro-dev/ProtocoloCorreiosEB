import Service from 'src/services/Service'
class BuscaProtocoloEntradaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('busca-protocoloentradas', {
      params: {
        busca
      }
    })
  }

  static procuraDocumento (dados) {
    return this.get('busca-protocoloentradas/documento', {
      params: dados
    })
  }

  static relatorio (dados) {
    return this.get('busca-protocoloentradas/relatorio', {
      params: dados
    })
  }
  static seleciona (obj) {
    return this.get(`busca-protocoloentradas/protocolo/${obj.protocolo}/ano/${obj.ano}`)
  }

  static getOptions () {
    return this.get(`busca-protocoloentradas/options`)
  }
}
export default BuscaProtocoloEntradaService
