import Dialogs from './dialogs'
import Loadings from './loadings'
import Notify from './notify'
import ConfereRegistroService from 'src/services/confereRegistro'
const tools = {

  getNomeOptions (value, options) {
    if (value) {
      const option = options.filter((option) => option.value === value)
      return option[0].label
    } else {
      return ''
    }
  },

  Dialogs: { ...Dialogs },
  Loadings: { ...Loadings },
  Notify: { ...Notify },
  service: ConfereRegistroService

}

export default tools
