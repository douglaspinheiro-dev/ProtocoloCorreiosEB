<template>
  <q-layout
    ref="layout"
    view="lHr LpR lfr"
    :left-class="{'bg-grey-2': true}"
  >
    <!--<root-header />-->
    <menu-left></menu-left>
    <!--<menu-right v-if="mostraMenuRight"></menu-right>-->

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script>
// import rootHeader from 'src/components/rootHeader'
import menuLeft from 'src/components/MenuLeft'

export default {
  name: 'LayoutRoot',
  components: {
    // rootHeader,
    menuLeft
  },
  data () {
    return {
      mostraBotaoMenuRight: true
    }
  },
  computed: {
    mostraMenuRight: {
      get () {
        return this.$store.state.menuRight.mostraMenuRight
      },
      set (val) {
        this.$store.commit('menuRight/setMostraMenuRight', val)
      }
    }
  },
  methods: {
  }
}
</script>
<style>
/* styles globais
*/
.form-input{
  margin: 10px;
}
.router-link-exact-active{
  background: blue
}
</style>
