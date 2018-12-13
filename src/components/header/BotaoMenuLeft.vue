<template>
  <q-btn flat round dense icon="menu" @click="toggleLeft" />
</template>

<script>
export default {
  // name: 'ComponentName',
  data () {
    return {}
  },
  methods: {
    toggleLeft () {
      this.$root.$emit('toggleLeft')
    }
  }
}
</script>

<style>
</style>
