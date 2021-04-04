<template>
  <q-checkbox
    :label="label" :class="classe" class="form-input"
    :hint="hint"
    :error="error"
    :error-message="errorMessage"
    :value="value"
    @input="val => $emit('input', val)"
    :name="name"
    :keep-color="keepColor"
    :indeterminate-value="valueIndeterminate"
    :toggle-indeterminate="indeterminateToggle"
    :tabindex="tabindex"
    :left-label="leftLabel"
    :true-value="trueValue"
    :false-value="falseValue"
    :disable="disable"
    :color="color"
    :dark="dark"
    :dense="dense"
  />
</template>

<script>
export default {
  name: 'DCheckbox',
  props: [
    // Behavior
    'keep-color',
    'indeterminateValue',
    'toggleIndeterminate',
    // General
    'tabindex',
    // Label
    'label',
    'leftLabel',
    // Model
    'value',
    // 'val',
    'trueValue',
    'falseValue',
    // State
    'disable',
    // Style
    'color',
    'dark',
    'dense',
    // Validate
    'hint',
    'error',
    'errorMessage',
    'name',
    // Css
    'classe'
  ],
  computed: {
    valueIndeterminate: function () { return this.indeterminateValue !== undefined },
    indeterminateToggle: function () { return this.toogleIndeterminate !== undefined }
  }
}
</script>
<style scoped>
  @import url('../css/index.css');
</style>
