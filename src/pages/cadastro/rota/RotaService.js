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

  static preencheSelect (obj) {
    return this.get('rotas', { params: obj.busca })
      .then(result => {
        const registros = result.data.registros.map(option => ({
          label: option.descricao,
          value: option.rota
        }))
        result.data.registros = registros
        return result.data
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
    return this.post('rotas/rota', rota)
  }

  static altera (rota) {
    return this.put(`rotas/rota/${rota.rota}`, rota)
  }

  static apaga (id) {
    return this.delete(`rotas/rota/${id}`)
  }
}
export default RotaService
