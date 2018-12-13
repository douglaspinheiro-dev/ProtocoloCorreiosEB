<template>
  <q-btn flat round dense icon="list" @click="toggleRight"/>
</template>

<script>
export default {
  // name: 'ComponentName',
  data () {
    return {}
  },
  methods: {
    toggleRight () {
      this.$root.$emit('toggleRight')
    }
  }
}
</script>

<style>
</style>
