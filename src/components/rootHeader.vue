<template>
  <q-layout-header>
    <q-toolbar>
      <q-btn flat round dense icon="menu" @click="toggleLeft" />
      <q-toolbar-title>
        {{ tituloModulo }}
      </q-toolbar-title>
      <q-btn flat round dense icon="list" @click="toggleRight"/>

    </q-toolbar>
  </q-layout-header>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  components: {
  },
  data () {
    return {
      tituloModulo: 'Dashboard'
    }
  },
  methods: {
    toggleLeft () {
      this.$root.$emit('toggleLeft')
    },
    toggleRight () {
      const menu = !this.getListagemDeRegistros
      this.$store.commit('menuRight/setListagemDeRegistros', menu)
    }
  },
  computed: {
    ...mapGetters({
      getListagemDeRegistros: 'menuRight/getListagemDeRegistros'
      // getLinks: 'getLinks',
      // getGrupoLogin: 'getGrupoLogin'
    })
  },
  created () {
    const self = this
    this.$root.$on('trocaTitulo', function (titulo) {
      self.tituloModulo = titulo
    })
  },
  beforeDestroy () {
    this.$root.$off('trocaTitulo')
  }
}
</script>

<style>

</style>
