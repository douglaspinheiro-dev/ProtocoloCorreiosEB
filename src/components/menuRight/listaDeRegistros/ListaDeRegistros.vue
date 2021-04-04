<template>
  <q-drawer
    v-model="mostraMenuRight"
    side="right"
    :width="tamanho"
  >
    <q-list
      no-border
      link
      inset-delimiter
    >
      <q-item-label header>{{labelHeader}}</q-item-label>
      <q-input
        class="form-input"
        debounce="1000"
        @input="pesquisando"
        v-model="busca"
        :hint="hint || ''"
        :placeholder="placeholder || 'busca'"
        icon="search"
        label="Busca"
        stack-label
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
      <q-infinite-scroll
        @load="onLoad" :offset="250"
        ref="infiniteScroll"
      >
        <slot name="qItem"/>
        <template v-slot:loading>
          <div class="row justify-center q-my-md">
            <q-spinner-dots color="primary" size="40px" />
          </div>
        </template>
      </q-infinite-scroll>
    </q-list>
  </q-drawer>
</template>

<script>
// import { mapGetters } from 'vuex'
export default {
  name: 'ListaDeRegistros',
  components: {
  },
  data () {
    return {
      mostraMenuRight: true,
      busca: ''
    }
  },
  props: ['labelHeader', 'stopInfinitScroll', 'placeholder', 'hint', 'tamanho'],
  methods: {
    onLoad  (index, done) {
      console.log('vou atualizar a lista ede registros')
      const busca = this.busca

      setTimeout(() => {
        this.$store.commit('listaDeRegistros/setBusca', busca)
        this.$store.commit('listaDeRegistros/setDone', done)
        this.$store.commit('listaDeRegistros/setIndex', index)

        this.$emit('atualizaLista', done)
        // dispara o metodo de procura no pai, que consulta o banco,
        // e altera o dado no store
      }, 1000)
    },
    pesquisando () {
      console.log('pesquisando.')
      this.$store.commit('listaDeRegistros/setRegistros', [])
      this.$store.commit('listaDeRegistros/setInicio', 0)
      this.$store.commit('listaDeRegistros/setFim', 200)
      this.$refs.infiniteScroll.resume()
      this.$refs.infiniteScroll.trigger()
    }
  },
  computed: {
    // ...mapGetters({
    //   // getRegistros: 'menuRight/getRegistros'
    // })
  },
  mounted () {
    this.$root.$on('toggleRight', () => {
      // vuex
      this.mostraMenuRight = !this.mostraMenuRight
    })
  },
  beforeDestroy () {
    this.$root.$off('toggleRight')
  }
}
</script>
