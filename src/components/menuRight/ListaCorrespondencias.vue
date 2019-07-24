<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right" :width="400">
    <q-list>
      <q-list-header>Correspondências</q-list-header>

        <q-search
          @input="pesquisando"
          v-model.lazy="busca"
          :debounce="300"
          placeholder="Busca  por protocolo"
          icon="search"
          stack-label="Busca"
        />

        <q-infinite-scroll :handler="loadMore" ref="infiniteScroll" >
          <!-- Content, in this case some <p> tags -->
          <q-item exact separator link highlight multiline v-for="(correspondencia, index) in listaDeRegistros"  item :to="{ name: 'alterarCorrespondencia', params: { id: correspondencia.correspondencia} }" :key="index">
            <q-item-main>
              <q-item-tile v-show="!correspondencia.correspondencia" label> {{ correspondencia.assunto }}</q-item-tile>
              <q-item-tile v-show="correspondencia.correspondencia" label> {{ `${correspondencia.setorDescricao} >>> ${correspondencia.destino}` }}</q-item-tile>
              <q-item-tile v-show="correspondencia.correspondencia" sublabel lines="2">{{`${correspondencia.tipoDocumentoDescricao} ${correspondencia.numeroDocumento} | Rastreio: ${correspondencia.codigoRastreio}` }} </q-item-tile>
            </q-item-main>
            <q-item-side v-show="correspondencia.correspondencia" right :stamp="`Prot: ${correspondencia.anoCadastro}-${correspondencia.protocolo}`" />
          </q-item>
          <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
            <q-spinner-dots :size="40" />
          </div>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import Correspondencia from 'src/services/correspondencia/Correspondencia'
import correspondenciaService from 'src/services/correspondencia/CorrespondenciaService'
import moment from 'src/tools/Moment'
export default {
  name: 'ListaCorrespondenciaes',
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
      console.log('vou atualizar a lista em correspondencias')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      correspondenciaService.procura(busca, inicio, fim)
        .then(result => {
          if (result.data.registros.length === 0 && inicio === 0) {
            console.log('sem registros')
            this.listaDeRegistros = [{
              assunto: 'Sem registros encontrados',
              dataDocumento: '',
              numero: '',
              origem: '',
              setorDescricao: '',
              correspondencia: '',
              tipoDocumentoDescricao: ''
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

    this.$root.$on('removeRegistro', (correspondencia) => {
      let idRegistro = this.registros.filter(registro => registro.correspondencia === correspondencia)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      console.log(novoRegistro)

      let idRegistro = this.registros.filter(registro => registro.correspondencia === novoRegistro.correspondencia)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id] = new Correspondencia(novoRegistro)
      this.registros[id].setorDescricao = novoRegistro.setorDescricao
      this.registros[id].tipoDocumentoDescricao = novoRegistro.tipoDocumentoDescricao
      this.registros[id].dataDocumento = moment(novoRegistro.dataDocumento).format('L')
      this.listaDeRegistros = Object.assign({}, this.listaDeRegistros, this.registros)
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let correspondencia = new Correspondencia(obj)
      correspondencia.dataDocumento = moment(obj.dataDocumento).format('L')
      correspondencia.setorDescricao = obj.setorDescricao
      correspondencia.tipoDocumentoDescricao = obj.tipoDocumentoDescricao
      this.registros.push(correspondencia)
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
