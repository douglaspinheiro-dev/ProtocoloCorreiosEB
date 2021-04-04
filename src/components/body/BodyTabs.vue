<template>
  <div>
    <header-page :titulo="titulo" :menuDireita="menuDireita" :menuEsquerda="menuEsquerda"/>
    <header-tabs :tabAtiva="tab" ref="headerTabs" @trocandoAba="trocandoAba">
      <slot name="tabHeader"/>
    </header-tabs>
    <tab-panels :tabAtiva="tab" style="height: calc(100vh - 50px);">
      <slot name="tabPanel"/>
    </tab-panels>
    <slot name="bodyNotTab"/>

  </div>
</template>

<script>
import HeaderPage from 'src/components/header/HeaderPage'
import HeaderTabs from 'src/components/header/HeaderTabs'
import TabPanels from 'src/components/body/TabPanels'
export default {
  name: 'BodyTabs',
  data () {
    return {
      tab: this.tabAtiva || 'tab-1'
    }
  },
  components: {
    HeaderPage,
    HeaderTabs,
    TabPanels
  },
  props: ['titulo', 'icone', 'corIcone', 'menuDireita', 'tabAtiva', 'menuEsquerda'],
  methods: {
    trocandoAba (event) {
      this.tab = event
      this.$emit('trocandoAba', event)
    }
  },
  watch: {
    tabAtiva: {
      handler: function (id) {
        if (id) {
          this.tab = id
        }
      },
      deep: true,
      immediate: true
    }
  }

}
</script>

<style>
</style>
