// import something here
import numeral from 'numeral'
// leave the export, even if you don't use it

numeral.register('locale', 'pt-br', {
  delimiters: {
    thousands: '.',
    decimal: ','
  },
  abbreviations: {
    thousand: 'mil',
    million: 'milhões',
    billion: 'b',
    trillion: 't'
  },
  ordinal: function (number) {
    return 'º'
  },
  currency: {
    symbol: 'R$'
  }
})
numeral.locale('pt-br')

export default numeral
