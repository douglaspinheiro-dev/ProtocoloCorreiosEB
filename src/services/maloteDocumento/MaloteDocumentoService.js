import http from 'src/boot/axios'
import {
  Dialog,
  Loading
} from 'quasar'
import Notify from '../../tools/Notify'

export const MaloteDocumentoService = {
  // usado para a lista de registros
  procura (busca, inicio, fim) {
    return http.get('malotedocumentos', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar malotedocumentos')
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
  lista (id) {
    return http.get(`malotedocumentos/malote/${id}`)
      .then(response => response)
      .catch(function (error) {
        console.log(`erro no servidor ao listar malotedocumentos`)
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

  seleciona (documento) {
    return http.get(`malotedocumentos/malotedocumento/${documento}`)
      .then(response => response)
      .catch(function (error) {
        Loading.hide()
        console.log('erro no servidor ao buscar um grupo de usuario', documento)
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

  grava (maloteDocumento) {
    return http.post(`malotedocumentos/malotedocumento`, maloteDocumento)
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
            message: 'Todos os campos são obrigatórios.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  altera (maloteDocumento) {
    return http.put(`malotedocumentos/malotedocumento/${maloteDocumento.maloteDocumento}`, maloteDocumento)
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
            message: 'Todos os campos são obrigatórios.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  apaga (obj) {
    console.log(obj)
    return http.delete(`malotedocumentos/malotedocumento/${obj}`)
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
  getOptions (rota) {
    return http.get(`malotedocumentos/options/${rota}`)
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
export default MaloteDocumentoService
