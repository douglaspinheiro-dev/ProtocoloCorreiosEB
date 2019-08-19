import store from 'src/store'
export const ListaDeRegistrosService = {

  atualizaLista (obj) {
    let inicio = store.getters['listaDeRegistros/getInicio']
    let fim = store.getters['listaDeRegistros/getFim']
    let busca = store.getters['listaDeRegistros/getBusca']
    console.log('vou atualizar a lista')
    obj.service.procura(busca, inicio, fim)
      .then(result => {
        console.log(result.data)

        if (result.data.registros.length === 0 && inicio === 0) {
          console.log('sem registros')
          store.commit('listaDeRegistros/setRegistros', obj.semRegistros)
          store.commit('listaDeRegistros/semRegistros', true)
          obj.self.$refs.listaDeRegistros.$refs.infiniteScroll.stop()
        } else {
          if (inicio === 0) {
            store.commit('listaDeRegistros/setRegistros', [])
          }
          store.commit('listaDeRegistros/adicionaRegistros', result.data.registros)
          if (result.data.fim === true) {
            console.log('fim da lista')
            obj.self.$refs.listaDeRegistros.$refs.infiniteScroll.stop()
          }
          store.commit('listaDeRegistros/setInicio', fim)
          store.commit('listaDeRegistros/setFim', fim + 200)
        }
        obj.done()
      })
  },
  pesquisando (self) {
    console.log('pesquisando...')
    store.commit('listaDeRegistros/setRegistros', [])
    store.commit('listaDeRegistros/setInicio', 0)
    store.commit('listaDeRegistros/setFim', 200)
    self.$refs.listaDeRegistros.$refs.infiniteScroll.resume()
  }
}
export default ListaDeRegistrosService
