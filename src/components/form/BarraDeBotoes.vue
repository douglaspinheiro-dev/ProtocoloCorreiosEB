<template>
  <div>
    <q-btn small class="col" type="reset" @click="reset" icon="add" v-if="possoGravar">Novo</q-btn>
    <q-btn small class="col" type="submit" icon="save" v-if="!id && possoGravar" >Gravar</q-btn>
    <q-btn small class="col" type="submit" icon="save" v-if="id && possoAlterar" >Alterar</q-btn>
    <q-btn small class="col" type="button" icon="delete" @click="excluir" v-if="possoExcluir">Excluir</q-btn>
  </div>
</template>

<script>
export default {
  name: 'BarraDeBotoes',
  props: {
    id: {},
    possoGravar: {},
    possoAlterar: {},
    possoExcluir: {}
  },
  methods: {
    reset () {
      this.$emit('reset')
    },
    submit () {
      this.$emit('submit')
    },
    excluir () {
      this.$emit('delete')
    }
  }
}
</script>

<style>

</style>
