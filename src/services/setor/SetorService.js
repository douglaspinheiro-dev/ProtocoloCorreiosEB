import http from 'src/plugins/axios'
import { Dialog, Loading } from 'quasar'
import Notify from '../../tools/Notify'
export const SetorService = {
  procura (busca, inicio, fim) {
    return http.get('setores', { params: { busca: busca, inicio: inicio, fim: fim } })
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

  grava (setor) {
    return http.post(`setores/setor`, setor)
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

  altera (setor) {
    return http.put(`setores/setor/${setor.setor}`, setor)
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
    return http.delete(`setores/setor/${id}`)
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
    return http.get(`setores/setor/${id}`)
      .then(response => response)
      .catch(error => {
        Loading.hide()
        console.log('erro no servidor ao buscar um setor', id)

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
export default SetorService
