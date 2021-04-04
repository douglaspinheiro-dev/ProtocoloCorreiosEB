import Service from 'src/services/Service'
class TipoCobrancaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('tipocobrancas', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (tipocobranca) {
    return this.post('tipocobrancas/tipocobranca', tipocobranca)
  }

  static altera (tipoCobranca) {
    return this.put(`tipocobrancas/tipocobranca/${tipoCobranca.tipoCobranca}`, tipoCobranca)
  }

  static apaga (id) {
    return this.delete(`tipocobrancas/tipocobranca/${id}`)
  }

  static seleciona (id) {
    return this.get(`tipocobrancas/tipocobranca/${id}`)
  }
}
export default TipoCobrancaService
