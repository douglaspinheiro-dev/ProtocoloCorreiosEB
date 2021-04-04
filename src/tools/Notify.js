import { Notify } from 'quasar'

export default {
  semPermissao: () => {
    Notify.create({
      type: 'negative',
      message: 'Você não tem permissão para esta operação.',
      timeout: 5000
    })
  },
  registrosEncontrados: () => {
    Notify.create({
      type: 'positive',
      message: 'Estes foram os registros encontrados.',
      timeout: 5000
    })
  },
  positive: (msg) => {
    Notify.create({
      type: 'positive',
      message: msg,
      timeout: 5000
    })
  },
  negative: (msg) => {
    Notify.create({
      type: 'negative',
      message: msg,
      timeout: 5000
    })
  },
  warning: (msg) => {
    Notify.create({
      type: 'warning',
      message: msg,
      timeout: 5000
    })
  }
}
