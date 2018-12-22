import http from 'src/plugins/axios'
import { Dialog, Loading } from 'quasar'
import Notify from '../../tools/Notify'

export const RotaEnderecoService = {
  // usado para a lista de registros
  procura (busca, inicio, fim) {
    return http.get('rotasenderecos', { params: { busca: busca, inicio: inicio, fim: fim } })
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar rotasenderecos')
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
    return http.get(`rotasenderecos/rota/${id}`)
      .then(response => response)
      .catch(function (error) {
        console.log(`erro no servidor ao listar rotasenderecos`)
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

  seleciona (endereco) {
    return http.get(`rotasenderecos/rota/${endereco.rota}/endereco/${endereco.endereco}`)
      .then(response => response)
      .catch(function (error) {
        Loading.hide()
        console.log('erro no servidor ao buscar um grupo de usuario', endereco)
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

  grava (rotaEndereco) {
    return http.post(`rotasenderecos/rotaendereco`, rotaEndereco)
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

  altera (rotaEndereco) {
    return http.put(`rotasenderecos/rota/${rotaEndereco.rota}/endereco/${rotaEndereco.endereco}`, rotaEndereco)
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
    return http.delete(`rotasenderecos/rotaendereco/${obj.rotaEndereco}`)
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
  getOptions () {
    return http.get(`rotasenderecos/options`)
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
export default RotaEnderecoService
