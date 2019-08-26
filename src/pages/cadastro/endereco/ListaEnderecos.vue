<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Endereços"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <q-item class="item-lista" multiline v-for="(endereco, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarEndereco', params: { id: endereco.endereco} }" exact :key="index">
        <q-item-label>
            <q-item-section header> {{ endereco.descricao }}</q-item-section>
            <q-item-section caption>{{ endereco.codigoReduzido }} </q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import enderecoService from './EnderecoService'
export default {
  name: 'ListaDeEnderecos',
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
        service: enderecoService,
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
