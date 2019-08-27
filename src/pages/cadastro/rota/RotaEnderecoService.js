import Service from 'src/services/Service'
class RotaEnderecoService extends Service {
  // usado para a lista de registros
  static procura (busca, inicio, fim) {
    return this.get('rotasenderecos', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  // usado para preencher selects
  static lista (id) {
    return this.get(`rotasenderecos/rota/${id}`)
  }

  static seleciona (endereco) {
    return this.get(`rotasenderecos/rota/${endereco.rota}/endereco/${endereco.endereco}`)
  }

  static grava (rotaEndereco) {
    return this.post(`rotasenderecos/rotaendereco`, rotaEndereco)
  }

  static altera (rotaEndereco) {
    return this.put(`rotasenderecos/rota/${rotaEndereco.rota}/endereco/${rotaEndereco.endereco}`, rotaEndereco)
  }

  static apaga (obj) {
    return this.delete(`rotasenderecos/rotaendereco/${obj.rotaEndereco}`)
  }
  static getOptions () {
    return this.get(`rotasenderecos/options`)
  }
}
export default RotaEnderecoService
