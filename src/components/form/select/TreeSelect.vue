<template>
  <q-field :label="label" stack-label>
    <template v-slot:control>
      <div tabindex="0" class="no-outline full-width">
        {{selected}}
      </div>
    </template>
    <template v-slot:append>
      <q-icon name="expand_more"></q-icon>
    </template>
    <q-menu fit auto-close>
      <q-input ref="filter" filled v-model="filter" label="Busca" autofocus>
        <template v-slot:append>
          <q-icon v-if="filter !== ''" name="clear" class="cursor-pointer" @click="resetFilter" />
        </template>
      </q-input>
      <q-tree
        :nodes="options"
        default-expand-all
        :selected.sync="selected"
        node-key="label"
        :filter="filter"
      >
        <template v-slot:default-header="prop">
          <div class="row items-center" @click="selecionado(prop.node)">
            <!-- <q-icon :name="prop.node.icon || 'share'" color="orange" size="28px" class="q-mr-sm" /> -->
            <div :class="!prop.node.analitica ? 'text-weight-bold' : ''">{{ prop.node.label }}</div>
          </div>
      </template>
      </q-tree>
    </q-menu>
  </q-field>
</template>

<script>
export default {
  // name: 'ComponentName',
  props: ['options', 'value', 'label'],
  data () {
    return {
      selected: this.value,
      filter: ''
    }
  },
  methods: {
    resetFilter () {
      this.filter = ''
      this.$refs.filter.focus()
    },
    selecionado (node) {
      this.$emit('input', node.value)
      this.$emit('inputObject', node)
    }
    // ticked (val) {
    //   console.log(val)
    // },
    // updated (val) {
    //   console.log(val)
    // }
  },
  watch: {
    value (value) {
      this.selected = value
    }
  }
}
</script>

<style>
</style>
