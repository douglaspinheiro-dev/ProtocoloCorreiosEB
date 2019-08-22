<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right">
    <q-list>
      <q-list-header>Malotes</q-list-header>

        <q-search
          @input="pesquisando"
          v-model.lazy="busca"
          :debounce="600"
          placeholder="Busca por malote"
          icon="search"
          stack-label="Busca"
        />

        <q-infinite-scroll :handler="loadMore" ref="infiniteScroll" >
          <!-- Content, in this case some <p> tags -->
          <q-item exact separator link highlight multiline v-for="(malote, index) in listaDeRegistros"  item :to="{ name: 'alterarMalote', params: { id: malote.malote} }" :key="index">
              <q-item-main>
                <q-item-tile label> {{ `${malote.data} | ${malote.rotaDescricao}` }}</q-item-tile>
              </q-item-main>
              <q-item-side right :stamp="`Prot: ${malote.protocolo}`" />
            <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
              <q-spinner-dots :size="40" />
            </div>
          </q-item>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import Malote from './Malote'
import maloteService from './MaloteService'
export default {
  name: 'ListaMalotes',
  components: {
  },
  data () {
    return {
      busca: '',
      registros: [],
      listaDeRegistros: [],
      inicio: 0,
      fim: 200,
      mostraMenuRight: true
    }
  },
  methods: {
    loadMore (index, done) {
      console.log('vou atualizar a lista em malotes')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      maloteService.procura(busca, inicio, fim)
        .then(result => {
          if (result.data.registros.length === 0 && inicio === 0) {
            console.log('sem registros')
            this.listaDeRegistros = [{
              data: '',
              rotaDescricao: 'Sem registros encontrados',
              malote: '',
              protocolo: ''
            }]
            this.registros = []
            this.$refs.infiniteScroll.stop()
          } else {
            if (inicio === 0) {
              this.registros = []
            }
            this.registros = this.registros.concat(result.data.registros)
            this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
            // this.$store.commit('menuRight/setRegistros', listaDeRegistros)
            if (result.data.fim === true) {
              console.log('fim da lista')
              this.$refs.infiniteScroll.stop()
            }
            this.inicio = fim
            this.fim = fim + 200
          }
          done()
        })
    },
    pesquisando () {
      console.log('pesquisando...')
      this.registros = []
      this.listaDeRegistros = []
      this.inicio = 0
      this.fim = 200
      this.$refs.infiniteScroll.resume()
    }
  },
  mounted () {
    this.$root.$on('toggleRight', () => {
      this.mostraMenuRight = !this.mostraMenuRight
    })

    this.$root.$on('removeRegistro', (malote) => {
      let idRegistro = this.registros.filter(registro => registro.malote === malote)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      let idRegistro = this.registros.filter(registro => registro.malote === novoRegistro.malote)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id] = new Malote(novoRegistro)
      this.registros[id].rotaDescricao = novoRegistro.rotaDescricao

      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let malote = new Malote(obj)
      malote.rotaDescricao = obj.rotaDescricao
      this.registros.push(malote)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })
  },
  beforeDestroy () {
    this.$root.$off('toggleRight')
    this.$root.$off('removeRegistro')
    this.$root.$off('alteraUnicoRegistro')
    this.$root.$off('adicionaRegistroNaLista')
  }
}
</script>
