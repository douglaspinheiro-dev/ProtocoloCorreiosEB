<template>
  <lista-de-registros
    ref="listaDeRegistros"
    labelHeader="Usuários"
    @atualizaLista="atualizaLista"

  >
    <template slot="qItem">
      <!-- Content, in this case some <p> tags -->
      <q-item class="item-lista" multiline v-for="(usuario, index) in getRegistros" :class="index%2 ? 'bg-blue-grey-1' : 'bg-blue-grey-2'" item :to="{ name: 'alterarUsuario', params: { id: usuario.usuario} }" exact :key="index">
        <q-item-label>
          <q-item-section header> {{ usuario.login + ' - ' + usuario.nome }}</q-item-section>
          <q-item-section caption v-if="usuario.email">{{ usuario.email }}</q-item-section>
        </q-item-label>
      </q-item>
    </template>
  </lista-de-registros>
</template>

<script>
import { mapGetters } from 'vuex'
import ListaDeRegistrosService from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros'
import ListaDeRegistros from 'src/components/menuRight/listaDeRegistros/ListaDeRegistros.vue'
import usuarioService from './UsuarioService'
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
        service: usuarioService,
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
