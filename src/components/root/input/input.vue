<template>
  <q-input
    :label="label" :class="classe"
    class="form-input"
    :hint="hint"
    :error="error"
    :error-message="error-message"
    :autocomplete="autocomplete"
    :type="type"
    @input="val => $emit('input', val)"
    :value="value"
    :name="name"
    :stack-label="stackLabel"
  />
</template>

<script>
export default {
  name: 'DInput',
  props: [
    // Behavior
    'mask',
    'fill-mask',
    'reverseFillMask',
    'unmaskedValue',
    'error',
    'rules',
    'lazyRules',
    'loading',
    'clearable',
    'autofocus',
    // Content
    'error-message',
    'noErrorIcon',
    'label',
    'stackLabel',
    'hint',
    'hideHint',
    'prefix',
    'suffix',
    'clearIcon',
    'bottomSlots',
    'counter',
    'itemsAligned',
    'autogrow',
    // General
    'type',
    // Model
    'value',
    'debounce',
    'maxlength',
    // State
    'disable',
    'readonly',
    // Style',
    'color',
    'bgColor',
    'dark',
    'filled',
    'outlined',
    'borderless',
    'standout',
    'hideBottomSpace',
    'rounded',
    'square',
    'dense',
    'inputClass',
    'inputStyle',
    // Css
    'classe',
    'name',
    // Custom
    'autocomplete'
  ]
}
</script>
<style scoped>
  @import url('../css/index.css');
</style>
