// import something here
import currency from 'currency.js'
// leave the export, even if you don't use it

const real = value => currency(value, {
  symbol: 'R$',
  separator: '',
  decimal: '.',
  formatWithSymbol: false,
  errorOnInvalid: false,
  precision: 2,
  pattern: '!#',
  negativePattern: '-!#'
})

export default real
