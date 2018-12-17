<template>
  <q-layout-drawer v-model="mostraMenuRight" side="right">
    <q-list>
      <q-list-header>Usuários</q-list-header>

        <q-search
          @input="pesquisando"
          v-model.lazy="busca"
          :debounce="300"
          placeholder="Pesquisa"
          icon="search"
          float-label="Pesquisa"
        />

        <q-infinite-scroll :handler="loadMore" ref="infiniteScroll" >
          <!-- Content, in this case some <p> tags -->
          <q-item exact separator link highlight multiline v-for="(usuario, index) in listaDeRegistros" item :to="{ name: 'alterarUsuario', params: { id: usuario.usuario} }" :key="index">
            <q-item-main>
              <q-item-tile label> {{ usuario.login }}</q-item-tile>
              <q-item-tile sublabel v-if="usuario.nome">{{ usuario.nome }}</q-item-tile>
            </q-item-main>
          </q-item>
          <div slot="message" class="row justify-center" style="margin-bottom: 50px;">
            <q-spinner-dots :size="40" />
          </div>
        </q-infinite-scroll>

    </q-list>
  </q-layout-drawer>
</template>

<script>
import { mapGetters } from 'vuex'
import Usuario from 'src/services/usuario/Usuario'
import usuarioService from 'src/services/usuario/UsuarioService'
export default {
  name: 'ListaUsuarios',
  components: {
  },
  data () {
    return {
      mascara: '',
      masked: false,
      busca: '',
      registros: [],
      listaDeRegistros: [],
      inicio: 0,
      fim: 200,
      mostraMenuRight: true
    }
  },
  methods: {
    loadMore (index, done) {
      console.log('vou atualizar a lista em usuarios')
      let inicio = this.inicio
      let fim = this.fim
      let busca = this.busca
      usuarioService.procura(busca, inicio, fim)
        .then(result => {
          console.log(result.data.registros.length)
          if (result.data.registros.length === 0 && inicio === 0) {
            console.log('sem registros')
            this.listaDeRegistros = [{
              login: 'Sem registros encontrados'
            }]
            this.registros = []
            this.$refs.infiniteScroll.stop()
          } else {
            if (inicio === 0) {
              this.registros = []
            }
            this.registros = this.registros.concat(result.data.registros)
            this.listaDeRegistros = this.registros
            // this.$store.commit('menuRight/setRegistros', listaDeRegistros)
            if (result.data.fim === true) {
              console.log('fim da lista')
              this.$refs.infiniteScroll.stop()
            }
            this.inicio = fim
            this.fim = fim + 200
          }
          done()
        })
    },
    pesquisando () {
      console.log('pesquisando...')
      this.registros = []
      this.listaDeRegistros = []
      this.inicio = 0
      this.fim = 200
      this.$refs.infiniteScroll.resume()
    }
  },
  computed: {
    ...mapGetters({
      // getRegistros: 'menuRight/getRegistros'
    })
  },
  mounted () {
    this.$root.$on('toggleRight', () => {
      this.mostraMenuRight = !this.mostraMenuRight
    })

    this.$root.$on('removeRegistro', (usuario) => {
      let idRegistro = this.registros.filter(registro => registro.usuario === usuario)
      this.registros.splice(this.registros.indexOf(idRegistro[0]), 1)
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('alteraUnicoRegistro', (novoRegistro) => {
      let idRegistro = this.registros.filter(registro => registro.usuario === novoRegistro.usuario)
      let id = this.registros.indexOf(idRegistro[0])
      this.registros[id].nome = novoRegistro.nome
      this.registros[id].login = novoRegistro.login
      this.listaDeRegistros = this.registros
    })

    this.$root.$on('adicionaRegistroNaLista', (obj) => {
      let usuario = new Usuario(obj.nome, obj.login, obj.email, obj.usuario)
      this.registros.push(usuario)
      this.listaDeRegistros = this.registros
    })
  },
  beforeDestroy () {
    this.$root.$off('toggleRight')
    this.$root.$off('removeRegistro')
    this.$root.$off('alteraUnicoRegistro')
    this.$root.$off('adicionaRegistroNaLista')
  }
}
</script>
