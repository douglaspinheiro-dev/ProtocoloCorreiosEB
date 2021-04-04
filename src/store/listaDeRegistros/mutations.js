export const removeRegistro = (state, obj) => {
  console.log('remover registro', obj)
  const idRegistro = state.registros.filter(registro => registro[obj.id] === obj.registro)
  state.registros.splice(state.registros.indexOf(idRegistro[0]), 1)
  if (state.registros.length === 0) {
    state.semRegistros = true
  }
}

export const alteraUnicoRegistro = (state, obj) => {
  const idRegistro = state.registros.filter(registro => {
    return registro[obj.id] === obj.registro[obj.id]
  })
  const id = state.registros.indexOf(idRegistro[0])
  const keys = Object.keys(obj.registro)
  keys.forEach(key => {
    state.registros[id][key] = obj.registro[key]
  })
}

export const adicionaRegistroNaLista = (state, obj) => {
  if (state.registros[0].descricao === 'Sem registros encontrados') {
    state.registros = [obj]
  } else {
    state.registros.push(obj)
  }
}

export const pesquisando = (state) => {
  state.registros = []
  state.semRegistros = true
  state.inicio = 0
  state.fim = 200
}

export const semRegistros = (state, semRegistros) => {
  state.semRegistros = semRegistros
}

export const setRegistros = (state, obj) => {
  state.registros = obj
}

export const setBusca = (state, busca) => {
  state.busca = busca
}
export const setDone = (state, done) => {
  state.done = done
}

export const setIndex = (state, index) => {
  state.index = index
}

export const setInicio = (state, inicio) => {
  state.inicio = inicio
}

export const setFim = (state, fim) => {
  state.fim = fim
}

export const resetaLista = (state) => {
  state.busca = ''
  state.registros = []
  state.inicio = 0
  state.fim = 200
  state.semRegistros = true
}

export const adicionaRegistros = (state, registros) => {
  state.registros = state.registros.concat(registros)
}
