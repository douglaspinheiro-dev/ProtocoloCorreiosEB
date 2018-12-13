<template>
  <q-search
    @input="pesquisando"
    v-model.lazy="search"
    :debounce="600"
    :placeholder="placeholder"
    :icon="icone"
    :float-label="textoDaPesquisa"
    :v-mask="mascara"
    :masked="masked"
    :type="type"
  />
</template>

<script>
import { mask } from 'vue-the-mask'
export default {
  name: 'inputPesquisa',
  components: {
  },
  data () {
    return {
      search: '',
      textoDaPesquisa: 'Pesquise pelo nome',
      icone: 'person',
      placeholder: 'Nome',
      mascara: '',
      masked: false,
      type: 'search'
    }
  },
  methods: {
    pesquisando: function () {
      if (this.search) {
        console.log('estou pesquisando isto: ' + this.search)
        this.$root.$emit('pesquisandoLista', this.search)
      } else {
        console.log('pesquisa esta vazia, volta registros')
        this.$root.$emit('pesquisandoLista', '')
      }
    }
  },
  created () {
    let self = this
    this.$root.$on('trocaTextoDaPesquisa', (obj) => {
      self.textoDaPesquisa = obj.texto
      self.icone = obj.icone
      self.placeholder = obj.placeholder
      self.mascara = obj.mascara
      self.masked = obj.masked
      self.search = obj.search
      self.type = obj.type
    })
  },
  beforeDestroy () {
    this.$q.events.$off('trocaTextoDaPesquisa')
  },
  directives: {
    mask
  }
}
</script>

<style>

</style>
