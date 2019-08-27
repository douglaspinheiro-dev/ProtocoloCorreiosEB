import Service from 'src/services/Service'
class UsuarioService extends Service {
  static procura (busca, inicio, fim) {
    return this.get('usuarios', {
      params: {
        busca: busca,
        inicio: inicio,
        fim: fim
      }
    })
  }

  static grava (usuario) {
    return this.post(`usuarios/usuario`, usuario)
  }

  static gravaAcessoEmpresa (acessoEmpresa) {
    return this.post(`usuarios/acessoempresa`, acessoEmpresa)
  }

  static altera (usuario) {
    return this.put(`usuarios/usuario/${usuario.usuario}`, usuario)
  }

  static apaga (id) {
    return this.delete(`usuarios/usuario/${id}`)
  }

  static seleciona (id) {
    return this.get(`usuarios/usuario/${id}`)
  }

  static alteraSenha (senhaAtual, senhaNova, grupo) {
    return this.put(`usuarios/senha`, {
      senhaAtual: senhaAtual,
      senhaNova: senhaNova,
      grupo: grupo
    })
  }

  static alteraSenhaOutroUsuario (id, senha, usuarioCriador) {
    return this.put(`usuarios/trocasenha`, {
      id,
      senha,
      usuarioCriador
    })
  }

  static buscalogin (login) {
    return this.get(`usuarios/buscalogin`, {
      params: {
        login: login
      }
    })
  }

  static buscaEmpresasDisponiveis (id) {
    return this.get(`usuarios/empresasdisponiveis/${id}`)
  }

  static removerEmpresaUsuario (id, usuario) {
    return this.put(`usuarios/acessoempresa/${id}`, {
      usuario: usuario
    })
  }

  static getOptions () {
    return this.get(`usuarios/options`)
  }
}
export default UsuarioService
