import Permissoes from 'src/services/permissoes/Permissoes'
export default class GrupoUsuario {
  constructor (obj = {}) {
    this.grupoUsuario = obj.grupoUsuario || ''
    this.codigo = obj.codigo || ''
    this.descricao = obj.descricao || ''
    this.usuarioCriador = obj.usuarioCriador || ''
    this.permissoes = obj.permissoes || new Permissoes()
  }
}
