import Permissoes from 'src/services/permissoes/Permissoes'
export default class GrupoUsuario {
  constructor (grupoUsuario = '', codigo = '', descricao = '', usuarioCriador = '') {
    this.grupoUsuario = grupoUsuario
    this.codigo = codigo
    this.descricao = descricao
    this.usuarioCriador = usuarioCriador
    this.permissoes = new Permissoes()
  }
}
