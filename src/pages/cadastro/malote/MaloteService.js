import Service from 'src/services/Service'
const rotasMalote = {
  malote: `/malotes`,
  grava: `/malotes/malote`,
  lista: `/malotes`,
  cadastro: (id) => `/malotes/malote/${id}`,
  options: `/malotes/options`
}

class MaloteService extends Service {
  // usado para a lista de registros
  static procura (busca, inicio, fim) {
    return this.get(rotasMalote.malote, {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  // usado para preencher selects
  static lista () {
    return this.get(rotasMalote.lista)
  }

  static seleciona (id) {
    return this.get(rotasMalote.cadastro(id))
  }

  static grava (malote) {
    return this.post(rotasMalote.grava, malote)
  }

  static altera (malote) {
    return this.put(rotasMalote.cadastro(malote.malote), malote)
  }

  static apaga (id) {
    return this.delete(rotasMalote.cadastro(id))
  }
  static getOptions () {
    return this.get(rotasMalote.options)
  }
}
export default MaloteService
