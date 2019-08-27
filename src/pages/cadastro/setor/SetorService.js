
import Service from 'src/services/Service'
const rotasSetor = {
  setor: `/setores`,
  grava: `/setores/setor`,
  pesquisa: `/setores/pesquisa`,
  cadastro: (id) => `/setores/setor/${id}`
}
class SetorService extends Service {
  static procura (busca, inicio, fim) {
    return this.get(rotasSetor.pesquisa, {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (setor) {
    return this.post(rotasSetor.grava, setor)
  }

  static seleciona (id) {
    return this.get(rotasSetor.cadastro(id))
  }

  static altera (setor) {
    return this.put(rotasSetor.cadastro(setor.setor), setor)
  }

  static apaga (id) {
    return this.delete(rotasSetor.cadastro(id))
  }
}
export default SetorService
