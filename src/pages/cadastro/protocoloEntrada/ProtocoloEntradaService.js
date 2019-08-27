import Service from 'src/services/Service'
class ProtocoloEntradaService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('protocoloentradas', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (protocoloentrada) {
    return this.post(`protocoloentradas/protocoloentrada`, protocoloentrada)
  }

  static altera (protocoloentrada) {
    return this.put(`protocoloentradas/protocoloentrada/${protocoloentrada.protocoloentrada}`, protocoloentrada)
  }

  static apaga (id) {
    return this.delete(`protocoloentradas/protocoloentrada/${id}`)
  }

  static seleciona (id) {
    return this.get(`protocoloentradas/protocoloentrada/${id}`)
  }
  static getOptions () {
    return this.get(`protocoloentradas/options`)
  }
}
export default ProtocoloEntradaService
