<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Malotes"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <!-- Content, in this case some <p> tags -->
      <q-item class="item-lista" multiline v-for="(malote, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarMalote', params: { id: malote.malote} }" exact :key="index">
        <q-item-label>
          <q-item-section header> {{ `${malote.data} ${malote.rotaDescricao}` }}</q-item-section>
          <q-item-section caption v-show="malote.data">Prot: {{malote.protocolo}}</q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

import maloteService from './MaloteService'
export default {
  name: 'ListaDeUsuarios',
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
        service: maloteService,
        semRegistros: [{
          rotaDescricao: 'Sem registros encontrados',
          data: '',
          protocolo: ''
        }],
        self: this,
        done
      })
    }
  }
}
</script>
