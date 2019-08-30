export const setAtivo = (state, ativo) => {
  state.ativo = ativo
}

export const setTitulo = (state, titulo) => {
  state.titulo = titulo
}

export const setLink = (state, link) => {
  state.link = link
}

export const setModalPdf = (state, dados) => {
  state.link = dados.link
  state.titulo = dados.titulo
  state.ativo = dados.ativo
}
