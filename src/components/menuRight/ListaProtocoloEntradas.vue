<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right" :width="400">
    <q-list>
      <q-list-header>Protocolos de Entrada</q-list-header>

        <q-search
          @input="pesquisando"
          v-model.lazy="busca"
          :debounce="300"
          placeholder="Busca"
          icon="search"
          stack-label="Busca"
        />

        <q-infinite-scroll :handler="loadMore" ref="infiniteScroll" >
          <!-- Content, in this case some <p> tags -->
          <q-item exact separator link highlight multiline v-for="(protocoloEntrada, index) in listaDeRegistros"  item :to="{ name: 'alterarProtocoloEntrada', params: { id: protocoloEntrada.protocoloEntrada} }" :key="index">
            <q-item-main>
              <q-item-tile label> {{ `${protocoloEntrada.dataDocumento} | ${protocoloEntrada.origem}` }}</q-item-tile>
              <q-item-tile sublabel lines="2">{{`${protocoloEntrada.tipoDocumentoDescricao} ${protocoloEntrada.numero} | ${protocoloEntrada.assunto}` }} </q-item-tile>
            </q-item-main>
            <q-item-side right :stamp="`Prot: ${protocoloEntrada.protocoloEntrada}`" />
          </q-item>
          <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
            <q-spinner-dots :size="40" />
          </div>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import ProtocoloEntrada from 'src/services/protocoloEntrada/ProtocoloEntrada'
import protocoloEntradaService from 'src/services/protocoloEntrada/ProtocoloEntradaService'
import moment from 'src/tools/Moment'
export default {
  name: 'ListaProtocoloEntradaes',
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
      console.log('vou atualizar a lista em protocoloEntradas')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      protocoloEntradaService.procura(busca, inicio, fim)
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

    this.$root.$on('removeRegistro', (protocoloEntrada) => {
      let idRegistro = this.registros.filter(registro => registro.protocoloEntrada === protocoloEntrada)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      console.log(novoRegistro)

      let idRegistro = this.registros.filter(registro => registro.protocoloEntrada === novoRegistro.protocoloEntrada)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id].assunto = novoRegistro.assunto
      this.registros[id].dataDocumento = moment(novoRegistro.dataDocumento).format('L')
      this.registros[id].numero = novoRegistro.numero
      this.registros[id].origem = novoRegistro.origem
      this.registros[id].setorDescricao = novoRegistro.setorDescricao
      this.registros[id].tipoDocumentoDescricao = novoRegistro.tipoDocumentoDescricao
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let protocoloEntrada = new ProtocoloEntrada()
      protocoloEntrada.protocoloEntrada = obj.protocoloEntrada

      protocoloEntrada.assunto = obj.assunto
      protocoloEntrada.dataDocumento = moment(obj.dataDocumento).format('L')
      protocoloEntrada.numero = obj.numero
      protocoloEntrada.origem = obj.origem
      protocoloEntrada.setorDescricao = obj.setorDescricao
      protocoloEntrada.tipoDocumentoDescricao = obj.tipoDocumentoDescricao
      this.registros.push(protocoloEntrada)
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
