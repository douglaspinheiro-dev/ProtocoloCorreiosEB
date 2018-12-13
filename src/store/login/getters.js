/*
export const someGetter = (state) => {}
 */
// export const getLogin = state => state.user.login
export const getLogin = (state) => {
  return state.user.login
}

export const getUserId = (state) => {
  return state.user.id
}
export const getUsuario = (state) => {
  return state.user.id
}

export const isLogged = (state) => {
  if (state.user.token === '') {
    return false
  } else {
    return true
  }
}

export const getEmpresaLogada = (state) => {
  return {
    empresa: state.empresa,
    nomeFantasia: state.nomeFantasia
  }
}

export const getEmpresasDisponiveis = (state) => {
  return state.empresasDisponiveis
}

export const getPermissoes = (state) => {
  return state.permissoes
}

export const getCategoriaUsuario = (state) => {
  return state.categoriaUsuario
}
