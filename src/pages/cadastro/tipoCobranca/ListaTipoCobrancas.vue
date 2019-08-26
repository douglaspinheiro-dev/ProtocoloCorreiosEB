<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Tipos de Correspondências"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(tipoCobranca, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarTipoCobranca', params: { id: tipoCobranca.tipoCobranca} }" exact :key="index">
        <q-item-section>
          <q-item-label>{{ tipoCobranca.descricao }}</q-item-label>
          <q-item-label caption>{{ tipoCobranca.codigo }}</q-item-label>
        </q-item-section>

        <q-item-section side>
          <q-item-label caption v-show="tipoCobranca.tipoCobranca">R$ {{tipoCobranca.valor}}</q-item-label>
        </q-item-section>
      </q-item>
    </template>
  </lista-de-registros>
</template>
<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import tipoCobrancaService from './TipoCobrancaService'
export default {
  name: 'ListaDeTipoCobranças',
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
        service: tipoCobrancaService,
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
