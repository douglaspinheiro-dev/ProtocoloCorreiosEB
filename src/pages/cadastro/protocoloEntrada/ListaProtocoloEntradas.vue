<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Documentos"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(protocoloEntrada, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarProtocoloEntrada', params: { id: protocoloEntrada.protocoloEntrada} }" exact :key="index">
        <q-item-section>
          <q-item-label> {{ `${protocoloEntrada.dataDocumento} | ${protocoloEntrada.origem}` }}</q-item-label>
          <q-item-label caption lines="2">{{`${protocoloEntrada.tipoDocumentoDescricao} ${protocoloEntrada.numero} | ${protocoloEntrada.assunto}` }} </q-item-label>
        </q-item-section>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import protocoloEntradaService from './ProtocoloEntradaService'

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
        service: protocoloEntradaService,
        semRegistros: [{
          tipoDocumentoDescricao: 'Sem registros encontrados',
          dataDocumento: ''
        }],
        self: this,
        done
      })
    }
  }
}
</script>
