import store from '../../store'
export const ValidaPermissoes = {
  abrir (modulo) {
    return store.getters['login/getPermissoes'][modulo].abrir
  },

  gravar (modulo) {
    return store.getters['login/getPermissoes'][modulo].inserir
  },

  alterar (modulo) {
    return store.getters['login/getPermissoes'][modulo].alterar
  },

  excluir (modulo) {
    return store.getters['login/getPermissoes'][modulo].excluir
  }
}
export default ValidaPermissoes
