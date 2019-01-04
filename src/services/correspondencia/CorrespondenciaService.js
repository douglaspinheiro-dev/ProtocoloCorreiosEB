import http from 'src/plugins/axios'
import { Dialog, Loading } from 'quasar'
import Notify from '../../tools/Notify'
export const CorrespondenciaService = {
  procura (busca, inicio, fim) {
    return http.get('correspondencias', { params: { busca: busca, inicio: inicio, fim: fim } })
      .then(response => response)
      .catch(error => {
        if (error.response.status === 401) {
          Notify.semPermissao()
        } else {
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
        }
        throw new Error(error)
      })
  },

  grava (correspondencia) {
    return http.post(`correspondencias/correspondencia`, correspondencia)
      .then(response => response)
      .catch(error => {
        console.log(error.response)
        Loading.hide()
        if (error.response.status === 401) {
          Notify.semPermissao()
        } else if (error.response.status === 500) {
          console.log('erro no servidor')
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {}).catch(() => {})
        } else if (error.response.status === 400) {
          Dialog.create({
            title: 'Atenção',
            message: 'Todos os campos são obrigatórios'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  altera (correspondencia) {
    return http.put(`correspondencias/correspondencia/${correspondencia.correspondencia}`, correspondencia)
      .then(response => response)
      .catch(error => {
        console.log(error.response)
        Loading.hide()
        if (error.response.status === 401) {
          Notify.semPermissao()
        } else if (error.response.status === 500) {
          console.log('erro no servidor')
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {}).catch(() => {})
        } else if (error.response.status === 400) {
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 400.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  apaga (id) {
    return http.delete(`correspondencias/correspondencia/${id}`)
      .then(response => response)
      .catch(error => {
        console.log(error.response)
        Loading.hide()
        if (error.response.status === 401) {
          Notify.semPermissao()
        } else if (error.response.status === 500) {
          console.log('erro no servidor')
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  seleciona (id) {
    return http.get(`correspondencias/correspondencia/${id}`)
      .then(response => response)
      .catch(error => {
        Loading.hide()
        console.log('erro no servidor ao buscar um correspondencia', id)

        if (error.response.status === 401) {
          Notify.semPermissao()
        } else {
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
        }
        throw new Error(error)
      })
  },
  getOptions () {
    return http.get(`correspondencias/options`)
      .then(response => response)
      .catch(error => {
        // throw new Error(error)
        Loading.hide()
        console.log('erro no servidor ao selecionar as options')

        if (error.response.status === 401) {
          Notify.semPermissao()
        } else {
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
        }
        throw new Error(error)
      })
  }
}
export default CorrespondenciaService
