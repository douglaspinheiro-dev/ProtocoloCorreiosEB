<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right">
    <q-list>
      <q-list-header>Setores Internos</q-list-header>

        <q-search
          @input="pesquisando"
          v-model.lazy="busca"
          :debounce="600"
          placeholder="Busca"
          icon="search"
          stack-label="Busca"
        />

        <q-infinite-scroll :handler="loadMore" ref="infiniteScroll" >
          <!-- Content, in this case some <p> tags -->
          <q-item exact separator link highlight multiline v-for="(setor, index) in listaDeRegistros"  item :to="{ name: 'alterarSetor', params: { id: setor.setor} }" :key="index">
            <q-item-main>
              <q-item-tile label> {{ setor.descricao }}</q-item-tile>
              <q-item-tile sublabel>{{ setor.codigoReduzido }} </q-item-tile>
            </q-item-main>
          </q-item>
          <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
            <q-spinner-dots :size="40" />
          </div>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import Setor from './Setor'
import setorService from './SetorService'
export default {
  name: 'ListaSetores',
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
      console.log('vou atualizar a lista em setors')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      setorService.procura(busca, inicio, fim)
        .then(result => {
          if (result.data.registros.length === 0 && inicio === 0) {
            console.log('sem registros')
            this.listaDeRegistros = [{
              descricao: 'Sem registros encontrados'
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

    this.$root.$on('removeRegistro', (setor) => {
      let idRegistro = this.registros.filter(registro => registro.setor === setor)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      let idRegistro = this.registros.filter(registro => registro.setor === novoRegistro.setor)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id] = new Setor(novoRegistro)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let setor = new Setor(obj)
      this.registros.push(setor)
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
