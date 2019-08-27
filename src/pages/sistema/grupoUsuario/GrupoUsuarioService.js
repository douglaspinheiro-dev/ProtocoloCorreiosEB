import Service from 'src/services/Service'
class GrupoUsuarioService extends Service {
  // usado para a lista de registros
  static procura (busca, inicio, fim) {
    return this.get('grupousuarios', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  // usado para preencher selects
  static lista () {
    return this.get('grupousuarios/lista')
  }
  static seleciona (id) {
    return this.get(`grupousuarios/grupousuario/${id}`)
  }

  static grava (grupoUsuario) {
    return this.post(`grupousuarios/grupousuario`, grupoUsuario)
  }

  static altera (grupoUsuario) {
    return this.put(`grupousuarios/grupousuario/${grupoUsuario.grupoUsuario}`, grupoUsuario)
  }

  static apaga (id) {
    return this.delete(`grupousuarios/grupousuario/${id}`)
  }
}
export default GrupoUsuarioService
