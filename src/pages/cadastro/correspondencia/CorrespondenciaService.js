import Service from 'src/services/Service'
class CorrespondenciaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('correspondencias', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (correspondencia) {
    return this.post('correspondencias/correspondencia', correspondencia)
  }

  static altera (correspondencia) {
    return this.put(`correspondencias/correspondencia/${correspondencia.correspondencia}`, correspondencia)
  }

  static apaga (id) {
    return this.delete(`correspondencias/correspondencia/${id}`)
  }

  static seleciona (id) {
    return this.get(`correspondencias/correspondencia/${id}`)
  }

  static getOptions () {
    return this.get('correspondencias/options')
  }
}
export default CorrespondenciaService
