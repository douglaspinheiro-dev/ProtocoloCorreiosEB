import Service from 'src/services/Service'
const rotasTipoCorrespondencia = {
  procura: `/tipocorrespondencias`,
  grava: `/tipocorrespondencias/tipocorrespondencia`,
  cadastro: (id) => `/tipocorrespondencias/tipocorrespondencia/${id}`,
  options: `/grupousuarios/options`
}

class TipoCorrespondenciaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get(rotasTipoCorrespondencia.procura, {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (tipocorrespondencia) {
    return this.post(rotasTipoCorrespondencia.grava, tipocorrespondencia)
  }

  static altera (tipoCorrespondencia) {
    return this.put(rotasTipoCorrespondencia.cadastro(tipoCorrespondencia.tipoCorrespondencia), tipoCorrespondencia)
  }
  static seleciona (id) {
    return this.get(rotasTipoCorrespondencia.cadastro(id))
  }

  static apaga (id) {
    return this.delete(rotasTipoCorrespondencia.cadastro(id))
  }
}
export default TipoCorrespondenciaService
