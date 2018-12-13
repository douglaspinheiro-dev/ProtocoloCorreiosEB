<template>
  <q-btn-group  class="fit">
    <q-btn type="button" :label="label ? label[0] : 'Ativo'" @click="radioButton" class="full-width" :push="!status ? true : false" :color="status ? 'primary' : ''"/>
    <q-btn type="button" :label="label ? label[1] : 'Inativo'" @click="radioButton" class="full-width" :push="status ? true : false" :color="!status ? 'primary' : ''"/>
  </q-btn-group>
</template>

<script>
export default {
  name: 'Radio2Button',
  methods: {
    radioButton () {
      this.$emit('toggleRadioButton')
    }
  },
  props: ['status', 'label']
}
</script>
