import Service from 'src/services/Service'
class EnderecoService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('enderecos', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (endereco) {
    return this.post('enderecos/endereco', endereco)
  }

  static altera (endereco) {
    return this.put(`enderecos/endereco/${endereco.endereco}`, endereco)
  }

  static apaga (id) {
    return this.delete(`enderecos/endereco/${id}`)
  }

  static seleciona (id) {
    return this.get(`enderecos/endereco/${id}`)
  }

  static getOptions () {
    return this.get('enderecos/options')
  }

  static buscaEnderecoPorCodigo (id) {
    return this.get(`enderecos/codigo/${id}`)
  }
}
export default EnderecoService
