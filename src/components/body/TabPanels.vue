<template>
  <q-tab-panels
    :value="tab"
    animated
  >
    <slot/>
  </q-tab-panels>
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
  watch: {
    tabAtiva: function (tab) {
      this.tab = tab
    }
  }
}
</script>

<style>
</style>
