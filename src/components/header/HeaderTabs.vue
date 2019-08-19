<template>
  <q-tabs
    ref="qTab"
    :value="tab"
    inline-label
    position="top"
    class="bg-primary text-white shadow-2"
    @input="trocandoAba"
    align="left"
  >
    <!-- Tabs - notice slot="title" -->
    <slot/>

  </q-tabs>
</template>

<script>
export default {
  // name: 'ComponentName',
  data () {
    return {
      tab: this.tabAtiva
    }
  },
  props: ['tabAtiva'],
  methods: {
    trocandoAba (event) {
      this.$emit('trocandoAba', event)
    }
  },
  watch: {
    tabAtiva: function (tab) {
      this.tab = tab
    }
  }
}
</script>

<style>
</style>
