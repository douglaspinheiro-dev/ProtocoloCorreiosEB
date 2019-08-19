import http from 'src/boot/axios'
import {
  Dialog,
  Loading
} from 'quasar'
import Notify from 'src/tools/Notify'
export const BuscaMaloteService = {
  procura (busca, inicio, fim) {
    return http.get('busca-malotes', {
      params: {
        busca
      }
    })
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

  procuraDocumento (dados) {
    return http.get('busca-malotes/documento', {
      params: dados
    })
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
  procuraMes (dados) {
    return http.get('busca-malotes/mes', {
      params: dados
    })
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

  relatorio (dados) {
    return http.get('busca-malotes/relatorio', {
      params: dados
    })
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

  relatorioConsolidadoPorMes (dados) {
    return http.get('busca-malotes/relatorio-por-mes', {
      params: dados
    })
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

  seleciona (obj) {
    return http.get(`busca-malotes/protocolo/${obj.protocolo}/ano/${obj.ano}`)
      .then(response => response)
      .catch(error => {
        Loading.hide()
        console.log('erro no servidor ao buscar um protocoloentrada', obj.id)

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
    return http.get(`busca-malotes/options`)
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
export default BuscaMaloteService
