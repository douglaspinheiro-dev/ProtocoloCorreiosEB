import { Notify } from 'quasar'

export default {
  semPermissao: () => {
    Notify.create({
      type: 'negative',
      message: 'Você não tem permissão para esta operação.',
      timeout: 5000
    })
  }
}
