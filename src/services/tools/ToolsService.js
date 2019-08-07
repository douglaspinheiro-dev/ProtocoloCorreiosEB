import http from '@/boot/axios'
import MsgDialog from 'src/tools/Dialogs'
import {
  Dialog
} from 'quasar'
export const ToolsService = {
  listaQuantidades () {
    return http.get('tools/quantidades')
      .then(response => response)
      .catch(error => {
        console.log('erro no servidor ao listar quantidades de clientes, mineradoras e mineracoes', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  },

  listaConfiguracoes () {
    return http.get('tools/config')
      .then(response => response)
      .catch(error => {
        console.log('erro no servidor ao listar configuracoes', error)
        MsgDialog(error, Dialog)
        throw new Error(error)
      })
  }
}
export default ToolsService
