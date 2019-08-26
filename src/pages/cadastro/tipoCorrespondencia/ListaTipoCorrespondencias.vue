<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Tipos de Correspondências"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(tipoCorrespondencia, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarTipoCorrespondencia', params: { id: tipoCorrespondencia.tipoCorrespondencia} }" exact :key="index">
        <q-item-label>
          <q-item-section header> {{ tipoCorrespondencia.descricao }}</q-item-section>
          <q-item-section caption>{{ tipoCorrespondencia.codigo }}</q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>
<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import tipoCorrespondenciaService from './TipoCorrespondenciaService'
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
        service: tipoCorrespondenciaService,
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
