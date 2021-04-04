<template>
  <!-- <q-field :class="classe" :label="label" borderless> -->
    <!-- <template v-slot:before>
      <q-avatar>
        <img src="https://cdn.quasar.dev/img/avatar5.jpg">
      </q-avatar>
    </template> -->

    <!-- <template v-slot:control> -->
      <q-select
        :class="classe" :label="label"
        :hint="hint"
        :error-message="errorMessage"
        :error="error"
        v-model="select"
        :options="options"
        use-input
        input-debounce="0"
        @filter="filterFn"
        @input="selecionado"
        :disable="disable"
      >
        <template v-if="select" v-slot:append>
          <q-icon name="cancel" @click.stop="limpaSelect" class="cursor-pointer" />
        </template>
        <template v-slot:no-option>
          <q-item>
            <q-item-section class="text-grey">
              Sem registros encontrados
            </q-item-section>
          </q-item>
        </template>
      </q-select>
    <!-- </template> -->

    <!-- <slot name="prepend" /> -->
  <!-- </q-field> -->

</template>

<script>
import QSelect from 'src/components/root/select/select.vue'
export default {
  name: 'QSelectTurbinado',
  components: {
    QSelect
  },
  props: [
    'label',
    'errorMessage',
    'hint',
    'classe',
    'error',
    'value',
    'placeholder',
    'service',
    'disable',
    'filtro',
    'msgSelecioneAnterior',
    'optSelecionado',
    'methodService'
  ],
  data () {
    return {
      options: [],
      select: '',
      timer: null
    }
  },
  methods: {
    limpaSelect () {
      this.select = {
        label: '',
        value: ''
      }
      this.selecionado()
    },
    filterFn (val, update, abort) {
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        const dados = {
          busca: {
            busca: val,
            inicio: 0,
            fim: 200
          }
        }
        if (this.filtro !== undefined) dados.busca.filtro = JSON.stringify(this.filtro)
        this.service[this.methodService](dados)
          .then(obj => {
            update(() => {
              this.options = obj.registros.length === 0 ? [{ label: 'Sem registros encontrados', value: null }] : obj.registros
            })
          })
      }, 300)
    },

    abortFilterFn () {
      // console.log('delayed filter aborted')
    },
    selecionado () {
      this.$emit('input', this.select.value)
      this.$emit('inputObject', this.select)
    },
    carregaOptions () {
      this.service[this.methodService]({ busca: { busca: '', inicio: 0, fim: 200 } })
        .then(obj => {
          console.log('obj', obj)
          this.options = obj.registros.length === 0 ? [{ label: 'Sem registros encontrados', value: null }] : obj.registros
        })
    }
  },
  watch: {
    value: {
      handler: function (value) {
        if (value) {
          if (this.options.length) {
            // conferir se o valor existe nos options, se existir, selecionar ele
            const existeOptions = this.options.filter(v => v.value === value)
            if (existeOptions.length) this.select = existeOptions[0]
            return
          }
          // this.select = this.options.filter(v => v.value === value)[0]
          // se nao existir, buscar o valor no banco e carregar este.
          this.select = this.optSelecionado
        } else {
          this.select = ''
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
