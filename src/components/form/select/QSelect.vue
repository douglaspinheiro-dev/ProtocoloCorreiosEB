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
        :options="opt"
        use-input
        input-debounce="0"
        @filter="filterFn"
        @input="selecionado"
        :filter-placeholder="placeholder"
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
export default {
  name: 'QSelectTurbinado',
  props: [
    'options',
    'label',
    'errorMessage',
    'hint',
    'classe',
    'error',
    'value',
    'placeholder',
    'disable'
  ],
  data () {
    return {
      opt: this.options,
      select: ''
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
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.opt = this.options
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.opt = this.options.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    selecionado () {
      console.log('selecionado')
      this.$emit('input', this.select.value)
      this.$emit('inputObject', this.select)
    }
  },
  watch: {
    value: {
      handler: function (value) {
        if (value) {
          this.select = this.options.filter(v => v.value === value)[0]
        } else {
          this.select = ''
        }
      },
      deep: true,
      immediate: true
    },
    options: {
      handler: function (options) {
        for (let index = 0; index < options.length; index++) {
          const opt = options[index]
          if (opt.value === this.select.value) {
            if (opt.label === this.select.label) return
            this.select = opt
            return
          }
        }
        this.select = ''
      },
      deep: true,
      immediate: true
    }
  }
}
</script>
