<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Correspondências"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <!-- Content, in this case some <p> tags -->
      <q-item class="item-lista" multiline v-for="(correspondencia, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarCorrespondencia', params: { id: correspondencia.correspondencia} }" exact :key="index">
        <q-item-label>
          <q-item-section v-show="!correspondencia.correspondencia" header> {{ correspondencia.assunto }}</q-item-section>
          <q-item-section caption v-show="correspondencia.correspondencia">{{ correspondencia.setorDescricao }} >>> {{ correspondencia.destino }}</q-item-section>
          <q-item-section caption v-show="correspondencia.correspondencia" >{{ correspondencia.tipoDocumentoDescricao }} {{correspondencia.numeroDocumento}} | Rastreio: {{correspondencia.codigoRastreio}}</q-item-section>
          <q-item-section caption v-show="correspondencia.correspondencia"  right :stamp="`Prot: ${correspondencia.anoCadastro}-${correspondencia.protocolo}`"/>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import correspondenciaService from './CorrespondenciaService'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'

export default {
  name: 'ListaCorrespondenciaes',
  components: {
    ListaDeRegistros
  },
  data () {
    return {
    }
  },
  computed: {
    ...mapGetters({
      getRegistros: 'listaDeRegistros/getRegistros'
    })
  },
  methods: {
    atualizaLista (done) {
      ListaDeRegistrosService.atualizaLista({
        service: correspondenciaService,
        semRegistros: [{
          login: 'Sem registros encontrados',
          nome: ''
        }],
        self: this,
        done
      })
    }
  }
}
</script>
