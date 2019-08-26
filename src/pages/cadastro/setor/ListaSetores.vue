<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Setores"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(setor, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarSetor', params: { id: setor.setor} }" exact :key="index">
        <q-item-section>
          <q-item-label> {{ setor.descricao }}</q-item-label>
          <q-item-label caption>{{ setor.codigoReduzido }} </q-item-label>
        </q-item-section>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import setorService from './SetorService'
export default {
  name: 'ListaSetores',
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
        service: setorService,
        semRegistros: [{
          descricao: 'Sem registros encontrados',
          codigoReduzido: ''
        }],
        self: this,
        done
      })
    }
  }
}
</script>
