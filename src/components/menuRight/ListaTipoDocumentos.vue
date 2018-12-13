<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right">
    <q-list no-border link inset-delimiter>
      <q-list-header>Tipos de Documentos</q-list-header>

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
          <q-item class="item-lista" multiline v-for="(tipoDocumento, index) in listaDeRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarTipoDocumento', params: { id: tipoDocumento.tipoDocumento} }" exact :key="index">
            <q-item-main>
              <q-item-tile label> {{ tipoDocumento.descricao }}</q-item-tile>
              <q-item-tile sublabel>{{ tipoDocumento.codigo }} </q-item-tile>
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
import TipoDocumento from 'src/services/tipoDocumento/TipoDocumento'
import tipoDocumentoService from 'src/services/tipoDocumento/TipoDocumentoService'
export default {
  name: 'ListaTipoDocumentos',
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
      console.log('vou atualizar a lista em tipoDocumentos')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      tipoDocumentoService.procura(busca, inicio, fim)
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
            this.listaDeRegistros = this.registros
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

    this.$root.$on('removeRegistro', (tipoDocumento) => {
      let idRegistro = this.registros.filter(registro => registro.tipoDocumento === tipoDocumento)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      let idRegistro = this.registros.filter(registro => registro.tipoDocumento === novoRegistro.tipoDocumento)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id].codigo = novoRegistro.codigo
      this.registros[id].descricao = novoRegistro.descricao
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let tipoDocumento = new TipoDocumento()
      tipoDocumento.tipoDocumento = obj.tipoDocumento
      tipoDocumento.codigo = obj.codigo
      tipoDocumento.descricao = obj.descricao
      this.registros.push(tipoDocumento)
      this.listaDeRegistros = this.registros
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
