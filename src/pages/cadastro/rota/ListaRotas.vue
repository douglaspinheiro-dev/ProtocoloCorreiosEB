<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Rotas"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(rota, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarRota', params: { id: rota.rota} }" exact :key="index">
        <q-item-section>
          <q-item-label> {{ rota.descricao }}</q-item-label>
          <q-item-label caption>{{ rota.codigo }}</q-item-label>
        </q-item-section>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import rotaService from './RotaService'
export default {
  name: 'ListaDeRotas',
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
        service: rotaService,
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
