/*
export const someMutation = (state) => {}
 */
import storage from 'localforage'
import http from 'src/boot/axios'

export const setLogin = (state, dados) => {
  state.user.login = dados.login
  state.user.id = dados.id
  state.categoriaUsuario = dados.categoriaUsuario
}

export const setToken = (state, token) => {
  storage.setItem('token', token)
  state.user.token = token
}

export const setSessaoInvalida = (state, valor) => {
  state.sessaoInvalida = valor
}

export const setAuth = (state, token) => {
  http.defaults.headers.common.token = token
}

export const setLinks = (state, links) => {
  state.links = links
}

export const setEmpresaLogada = (state, empresa) => {
  console.log('empresa', empresa)
  state.empresa = empresa.empresa
  state.nomeFantasia = empresa.nomeFantasia
  state.categoriaUsuario = empresa.categoriaUsuario
}

export const setEmpresasDisponiveis = (state, empresas) => {
  state.empresasDisponiveis = empresas
}

export const setPermissoes = (state, permissoes) => {
  state.permissoes = permissoes
}

export const removeToken = (state, token) => {
  storage.clear()
  state.user.token = ''
}
