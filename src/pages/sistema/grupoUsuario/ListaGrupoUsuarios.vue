<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Grupos de Usuários"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <!-- Content, in this case some <p> tags -->
      <q-item class="item-lista" multiline v-for="(grupoUsuario, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarGrupoUsuario', params: { id: grupoUsuario.grupoUsuario} }" exact :key="index">
        <q-item-label>
          <q-item-section header> {{ grupoUsuario.codigo }}</q-item-section>
          <q-item-section caption v-if="grupoUsuario.descricao">{{ grupoUsuario.descricao }}</q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'
import grupoUsuarioService from './GrupoUsuarioService'
export default {
  name: 'ListaGrupoDeUsuarios',
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
        service: grupoUsuarioService,
        semRegistros: [{
          codigo: 'Sem registros encontrados'
        }],
        self: this,
        done
      })
    }
  }
}
</script>
