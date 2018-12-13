// import storage from 'localforage'
import createPlugin from 'logrocket-vuex'
import LogRocket from 'logrocket'
const logrocketPlugin = createPlugin(LogRocket)

export default {
  user: {
    login: '',
    token: '',
    id: ''
  },
  inicioDaLista: 0,
  fimDaLista: 200,
  sessaoInvalida: false,
  estouAqui: '',
  empresa: '',
  nomeFantasia: '',
  categoriaUsuario: '',
  empresasDisponiveis: [],
  permissoes: [],
  plugins: [logrocketPlugin]
}
