<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Tipos de Documentos"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(tipoDocumento, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarTipoDocumento', params: { id: tipoDocumento.tipoDocumento} }" exact :key="index">
        <q-item-label>
          <q-item-section header> {{ tipoDocumento.descricao }}</q-item-section>
          <q-item-section caption>{{ tipoDocumento.codigo }}</q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import tipoDocumentoService from './TipoDocumentoService'
export default {
  name: 'ListaDeTipoDocumentos',
  components: {
    ListaDeRegistros
  },
  data () { return { } },
  computed: {
    ...mapGetters({
      getRegistros: 'listaDeRegistros/getRegistros'
    })
  },
  methods: {
    atualizaLista (done) {
      ListaDeRegistrosService.atualizaLista({
        service: tipoDocumentoService,
        semRegistros: [{
          descricao: 'Sem registros encontrados',
          codigo: ''
        }],
        self: this,
        done
      })
    }
  }
}
</script>
