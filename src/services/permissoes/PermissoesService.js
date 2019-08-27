import Service from 'src/services/Service'
class PermissoesService extends Service {
  static busca (id) {
    return this.get(`grupousuarios/permissoes/${id}`)
  }

  static grava (grupoUsuario) {
    return this.post(`grupousuarios/permissoes`, grupoUsuario)
  }

  static altera (grupoUsuario) {
    return this.put(`grupousuarios/permissoes/${grupoUsuario.grupoUsuario}`, grupoUsuario)
  }

  static apaga (id) {
    return this.delete(`grupousuarios/permissoes/${id}`)
  }
}
export default PermissoesService
