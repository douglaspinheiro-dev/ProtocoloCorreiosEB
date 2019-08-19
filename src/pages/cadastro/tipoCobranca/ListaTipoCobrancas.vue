<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right">
    <q-list>
      <q-list-header>Tipos de Cobranças</q-list-header>

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
          <q-item exact separator link highlight multiline v-for="(tipoCobranca, index) in listaDeRegistros" item :to="{ name: 'alterarTipoCobranca', params: { id: tipoCobranca.tipoCobranca} }" :key="index">
            <q-item-main>
              <q-item-tile label> {{ tipoCobranca.descricao }}</q-item-tile>
              <q-item-tile sublabel>{{ tipoCobranca.codigo }} </q-item-tile>
            </q-item-main>
            <q-item-side right :stamp="`R$ ${tipoCobranca.valor}`" v-show="tipoCobranca.tipoCobranca"/>
          </q-item>
          <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
            <q-spinner-dots :size="40" />
          </div>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import TipoCobranca from 'src/services/tipoCobranca/TipoCobranca'
import tipoCobrancaService from 'src/services/tipoCobranca/TipoCobrancaService'
export default {
  name: 'ListaTipoCobrancas',
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
      console.log('vou atualizar a lista em tipoCobrancas')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      tipoCobrancaService.procura(busca, inicio, fim)
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

    this.$root.$on('removeRegistro', (tipoCobranca) => {
      let idRegistro = this.registros.filter(registro => registro.tipoCobranca === tipoCobranca)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      let idRegistro = this.registros.filter(registro => registro.tipoCobranca === novoRegistro.tipoCobranca)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id] = new TipoCobranca(novoRegistro)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let tipoCobranca = new TipoCobranca(obj)
      this.registros.push(tipoCobranca)
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
