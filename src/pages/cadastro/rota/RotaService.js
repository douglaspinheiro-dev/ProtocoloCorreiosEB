import Service from 'src/services/Service'
class RotaService extends Service {
  // usado para a lista de registros
  static procura (busca, inicio, fim) {
    return this.get('rotas', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  // usado para preencher selects
  static lista () {
    return this.get('rotas/lista')
  }

  static seleciona (id) {
    return this.get(`rotas/rota/${id}`)
  }

  static grava (rota) {
    return this.post(`rotas/rota`, rota)
  }

  static altera (rota) {
    return this.put(`rotas/rota/${rota.rota}`, rota)
  }

  static apaga (id) {
    return this.delete(`rotas/rota/${id}`)
  }
}
export default RotaService
