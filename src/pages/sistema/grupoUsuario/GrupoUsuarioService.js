import http from 'src/boot/axios'
import {
  Dialog,
  Loading
} from 'quasar'
import Notify from 'src/tools/Notify'

export const GrupoUsuarioService = {
  // usado para a lista de registros
  procura (busca, inicio, fim) {
    return http.get('grupousuarios', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar grupos de usuario')
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
    return http.get('grupousuarios/lista')
      .then(response => response)
      .catch(function (error) {
        console.log('erro no servidor ao listar grupos de usuario')
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
    return http.get(`grupousuarios/grupousuario/${id}`)
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

  grava (grupoUsuario) {
    return http.post(`grupousuarios/grupousuario`, grupoUsuario)
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

  altera (grupoUsuario) {
    return http.put(`grupousuarios/grupousuario/${grupoUsuario.grupoUsuario}`, grupoUsuario)
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
            message: 'Todos os campos são obrigatórios, e senha mínima de 5 caracteres.'
          }).then(() => {}).catch(() => {})
        }
        throw new Error(error)
      })
  },

  apaga (id) {
    return http.delete(`grupousuarios/grupousuario/${id}`)
      .then(response => response)
      .catch(error => {
        console.log(error.response)
        Loading.hide()
        if (error.response.status === 401) {
          Dialog.create({
            title: 'Atenção',
            message: 'Sem permissão para esta operação.'
          }).then().catch()
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
export default GrupoUsuarioService
