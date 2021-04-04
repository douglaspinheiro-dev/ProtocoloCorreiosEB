import { Loading } from 'quasar'

const Loadings = {
  hide: () => {
    Loading.hide()
  },
  processando: () => {
    Loading.show({
      message: 'Processando sua requisição',
      messageColor: 'white',
      spinnerSize: 250, // in pixels
      spinnerColor: 'white'
    })
  },
  localizando: () => {
    Loading.show({
      message: 'Localizando o registro',
      messageColor: 'white',
      spinnerSize: 250, // in pixels
      spinnerColor: 'white'
    })
  }

}

export default Loadings
