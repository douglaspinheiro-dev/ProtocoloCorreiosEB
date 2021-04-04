import http from 'src/boot/axios'
import {
  Dialog
} from 'quasar'
let timer
const confereRegistro = function (tabela, campo, opcao, id, campoId, valor, campo2, valor2) {
  return new Promise((resolve, reject) => {
    clearTimeout(timer)
    timer = setTimeout(() => {
      http.get('registros/confere', {
        params: {
          tabela,
          campo,
          opcao,
          id,
          campoId,
          valor,
          campo2,
          valor2
        }
      }).then(response => resolve(response))
        .catch(function (error) {
          // throw new Error(error)
          console.log('erro no servidor')
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
          reject(error)
          throw new Error(error)
        })
    }, 500)
  })
}
export default confereRegistro
