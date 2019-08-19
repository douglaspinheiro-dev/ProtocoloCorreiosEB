import http from 'src/boot/axios'
import {
  Dialog,
  Loading
} from 'quasar'
import Notify from '../../../tools/Notify'

export const UsuarioService = {
  procura (busca, inicio, fim) {
    return http.get('usuarios', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
      .then(response => response)
      .catch(error => {
        console.log('erro no servidor ao listar  usuario')
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

  grava (usuario) {
    return http.post(`usuarios/usuario`, usuario)
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

  gravaAcessoEmpresa (acessoEmpresa) {
    return http.post(`usuarios/acessoempresa`, acessoEmpresa)
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

  altera (usuario) {
    return http.put(`usuarios/usuario/${usuario.usuario}`, usuario)
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

  apaga (id) {
    return http.delete(`usuarios/usuario/${id}`)
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
    return http.get(`usuarios/usuario/${id}`)
      .then(response => response)
      .catch(error => {
        Loading.hide()
        console.log('erro no servidor ao buscar um usuario', id)
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

  alteraSenha (senhaAtual, senhaNova, grupo) {
    return http.put(`usuarios/senha`, {
      senhaAtual: senhaAtual,
      senhaNova: senhaNova,
      grupo: grupo
    }).then(response => response)
      .catch(error => {
        console.log(error.response)
        if (error.response.status === 401) {
          Notify.semPermissao()
        } else if (error.response.status === 500) {
          console.log('erro no servidor')
          Dialog.create({
            title: 'Atenção',
            message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
        } else if (error.response.status === 400) {
          Dialog.create({
            title: 'Atenção',
            message: 'Todos os campos são obrigatórios, e senha mínima de 5 caracteres.'
          }).then(() => {
            // Picked "OK"
          }).catch(() => {
            // Picked "Cancel" or dismissed
          })
        }
        throw new Error(error)
      })
  },

  alteraSenhaOutroUsuario (id, senha, usuarioCriador) {
    return http.put(`usuarios/trocasenha`, {
      id,
      senha,
      usuarioCriador
    }).then(response => response)
      .catch(error => {
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

  buscalogin (login) {
    return http.get(`usuarios/buscalogin`, {
      params: {
        login: login
      }
    })
      .then(function (response) {
        return {
          response: response,
          status: 'success'
        }
      })
      .catch(function (error) {
        return {
          response: error,
          status: 'error'
        }
      })
  },

  buscaEmpresasDisponiveis (id) {
    return http.get(`usuarios/empresasdisponiveis/${id}`)
      .then(response => response)
      .catch(error => {
        Loading.hide()
        console.log('erro no servidor ao buscar empresas disponiveis para permissao', id)
        Dialog.create({
          title: 'Atenção',
          message: 'O servidor respondeu erro interno, contate o suporte e informe o erro 500.'
        }).then(() => {
          // Picked "OK"
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
        throw new Error(error)
      })
  },

  removerEmpresaUsuario (id, usuario) {
    return http.put(`usuarios/acessoempresa/${id}`, {
      usuario: usuario
    })
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
    return http.get(`usuarios/options`)
      .then(response => response)
      .catch(error => {
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
  }
}
export default UsuarioService
