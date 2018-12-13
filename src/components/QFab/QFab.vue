<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]"
   v-if="
      possoGravar ||
      possoAlterar ||
      possoExcluir
   "
   >
   <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
      <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
         Botões de ação
      </q-tooltip>

      <q-fab-action color="positive" icon="save" @click="$emit('salvarAlterar')" v-if="!id && possoGravar" >
         <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Gravar</q-tooltip>
      </q-fab-action>

      <q-fab-action color="positive" icon="save" @click="$emit('salvarAlterar')" v-if="id && possoAlterar" >
         <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Alterar</q-tooltip>
      </q-fab-action>

      <q-fab-action color="secondary" type="reset" @click="$emit('reset')" icon="add" v-if="possoGravar">
         <q-tooltip anchor="center left" self="center right" :offset="[20, 0]" >Novo</q-tooltip>
      </q-fab-action>

      <q-fab-action color="negative" type="button" @click="$emit('excluir')" icon="delete"
         v-if="possoExcluir"
      >
         <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Excluir</q-tooltip>
      </q-fab-action>

   </q-fab>
   </q-page-sticky>
</template>

<script>
export default {
  name: 'BotaoFlutuante',
  data () {
    return {
    }
  },
  props: [
    'possoGravar',
    'possoAlterar',
    'possoExcluir',
    'id'
  ]
}
</script>
