import http from 'src/boot/axios'
import {
  Dialog,
  Loading
} from 'quasar'
import Notify from 'src/tools/Notify'

export const RotaService = {
  // usado para a lista de registros
  procura (busca, inicio, fim) {
    return http.get('rotas', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar rotas')
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

  // usado para preencher selects
  lista () {
    return http.get('rotas/lista')
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar rotas')
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

  seleciona (id) {
    return http.get(`rotas/rota/${id}`)
      .then(response => response)
      .catch(function (error) {
        Loading.hide()
        console.log('erro no servidor ao buscar um grupo de usuario', id)
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

  grava (rota) {
    return http.post(`rotas/rota`, rota)
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
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  altera (rota) {
    return http.put(`rotas/rota/${rota.rota}`, rota)
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
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  apaga (id) {
    return http.delete(`rotas/rota/${id}`)
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
  }
}
export default RotaService
