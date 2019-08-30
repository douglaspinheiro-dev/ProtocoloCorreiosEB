export const getAtivo = (state) => {
  return state.ativo
}

export const getLink = (state) => {
  return state.link
}

export const getTitulo = (state) => {
  return state.titulo
}

export const getModalPdf = (state) => {
  return {
    titulo: state.titulo,
    link: state.link,
    ativo: state.ativo
  }
}
