<template>
  <q-header
    reveal
    elevated
    class="bg-primary text-white"
  >
    <q-toolbar>
      <botao-menu-left v-if="menuEsquerda !== false" />
      <q-toolbar-title>
        {{titulo}}
      </q-toolbar-title>
      <botao-menu-right v-if="menuDireita !== false" />

      <!-- <q-btn
          dense
          flat
          round
          icon="menu"
          @click="right = !right"
        /> -->
    </q-toolbar>
  </q-header>
</template>

<script>
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'

export default {
  name: 'HeaderPage',
  components: {
    BotaoMenuLeft,
    BotaoMenuRight
  },
  data () {
    return {}
  },
  props: ['titulo', 'icone', 'corIcone', 'menuEsquerda', 'menuDireita']
}
</script>

<style>
</style>
