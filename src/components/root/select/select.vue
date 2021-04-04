<template>
  <q-select
    class="form-select"
    :label="label"
    :class="classe"
    :hint="hint"
    :error="error"
    :error-message="errorMessage"
    :value="value"
    :name="name"
    :options="options"
    :use-input="useInput"
    :input-debounce="inputDebounce"
    :disable="disable"

    @virtual-scroll="val => $emit('virtual-scroll', val)"
    @clear ="val => $emit('clear ', val)"
    @remove="val => $emit('remove', val)"
    @input="val => $emit('input', val)"
    @add="val => $emit('add', val)"
    @new-value="(inputValue, doneFn) => $emit('new-value', inputValue, doneFn)"
    @filter ="(inputValue, doneFn, abortFn) => $emit('filter', inputValue, doneFn, abortFn)"
    @filter-abort ="val => $emit('filter-abort', val)"
    @popup-show="val => $emit('popup-show', val)"
    @popup-hide="val => $emit('popup-hide', val)"
  />
</template>

<script>
export default {
  name: 'DSelect',
  props: [
    // Behavior
    'virtualScrollHorizontal',
    'error',
    'rules',
    'lazy-rules',
    'loading',
    'clearable',
    'autofocus',
    'hideDropdownIcon',
    'fillInput',
    'newValueMode',
    'transitionShow',
    'transitionHide',
    'behavior',

    // Content
    'errorMessage',
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
    'dropdownIcon',
    'useInput',
    'inputDebounce',
    // Model
    'value',
    'multiple',
    'emit-value',
    // Options
    'options',
    'optionValue',
    'optionLabel',
    'optionDisable',
    'optionsDense',
    'optionsDark',
    'optionsSelectedClass',
    'optionsCover',
    'optionsSanitize',
    'mapOptions',
    // Selection
    'displayValue',
    'displayValueSanitize',
    'hideSelected',
    'maxValues',
    'useChips',

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
    'popupContentClass',
    'popupContentStyle',
    'inputClass',
    'inputStyle',
    // Virtual Scroll
    'virtualScrollSliceSize',
    'virtualScrollItemSize',
    'virtualScrollStickySizeStart',
    'virtualScrollStickySizeEnd',
    // Css
    'classe',
    'name'
  ]
}
</script>
<style scoped>
  @import url('../css/index.css');
</style>
