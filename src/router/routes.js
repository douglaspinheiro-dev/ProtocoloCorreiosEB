
export default [
  { path: '/', component: () => import('pages/login') },
  { path: '/consulta', component: () => import('pages/cadastro/correspondencia/consultaCorrespondencia') },
  {
    path: '/root',
    component: () => import('layouts/root'),
    name: 'layoutRoot',
    meta: { requerAutenticacao: true },
    children: [
      { path: '/dashboard', name: 'dashboard', component: () => import('pages/dashboard/dashboard.vue'), meta: { rota: 'dashboard', requerAutenticacao: true } },
      { path: '/dashboard/:primeiroLogin', name: 'dashboardPrimeiroLogin', component: () => import('pages/dashboard/dashboard.vue'), meta: { rota: 'dashboard', requerAutenticacao: true }, props: true },
      { path: '/grupousuarios', name: 'grupoUsuario', component: () => import('pages/sistema/grupoUsuario/GrupoUsuario.vue'), meta: { rota: 'grupoUsuario', requerAutenticacao: true } },
      { path: '/grupousuarios/grupousuario/:id', name: 'alterarGrupoUsuario', component: () => import('pages/sistema/grupoUsuario/GrupoUsuario.vue'), meta: { rota: 'grupoUsuario', requerAutenticacao: true }, props: true },
      { path: '/usuarios', name: 'usuario', component: () => import('pages/sistema/usuario/Usuario.vue'), meta: { rota: 'usuario', requerAutenticacao: true } },
      { path: '/usuarios/usuario/:id', name: 'alterarUsuario', component: () => import('pages/sistema/usuario/Usuario.vue'), meta: { rota: 'usuario', requerAutenticacao: true }, props: true },
      { path: '/tipodocumentos', name: 'tipoDocumento', component: () => import('pages/cadastro/tipoDocumento/TipoDocumento.vue'), meta: { rota: 'tipoDocumento', requerAutenticacao: true } },
      { path: '/tipodocumentos/tipodocumento/:id', name: 'alterarTipoDocumento', component: () => import('pages/cadastro/tipoDocumento/TipoDocumento.vue'), meta: { rota: 'tipoDocumento', requerAutenticacao: true }, props: true },
      { path: '/tipocorrespondencias', name: 'tipoCorrespondencia', component: () => import('pages/cadastro/tipoCorrespondencia/TipoCorrespondencia.vue'), meta: { rota: 'tipoCorrespondencia', requerAutenticacao: true } },
      { path: '/tipocorrespondencias/tipocorrespondencia/:id', name: 'alterarTipoCorrespondencia', component: () => import('pages/cadastro/tipoCorrespondencia/TipoCorrespondencia.vue'), meta: { rota: 'tipoCorrespondencia', requerAutenticacao: true }, props: true },
      { path: '/enderecos', name: 'endereco', component: () => import('pages/cadastro/endereco/Endereco.vue'), meta: { rota: 'endereco', requerAutenticacao: true } },
      { path: '/enderecos/endereco/:id', name: 'alterarEndereco', component: () => import('pages/cadastro/endereco/Endereco.vue'), meta: { rota: 'endereco', requerAutenticacao: true }, props: true },
      { path: '/setores', name: 'setor', component: () => import('pages/cadastro/setor/Setor.vue'), meta: { rota: 'setor', requerAutenticacao: true } },
      { path: '/setores/setor/:id', name: 'alterarSetor', component: () => import('pages/cadastro/setor/Setor.vue'), meta: { rota: 'setor', requerAutenticacao: true }, props: true },
      { path: '/protocoloentradas', name: 'protocoloEntrada', component: () => import('pages/cadastro/protocoloEntrada/ProtocoloEntrada.vue'), meta: { rota: 'protocoloEntrada', requerAutenticacao: true } },
      { path: '/protocoloentradas/extensao', name: 'protocoloEntradaExtensao', component: () => import('pages/cadastro/protocoloEntrada/ProtocoloEntradaExtensao.vue'), meta: { rota: 'protocoloEntrada', requerAutenticacao: true } },
      { path: '/protocoloentradas/protocoloentrada/:id', name: 'alterarProtocoloEntrada', component: () => import('pages/cadastro/protocoloEntrada/ProtocoloEntrada.vue'), meta: { rota: 'protocoloEntrada', requerAutenticacao: true }, props: true },
      { path: '/rotas', name: 'rota', component: () => import('pages/cadastro/rota/Rota.vue'), meta: { rota: 'rota', requerAutenticacao: true } },
      { path: '/rotas/rota/:id', name: 'alterarRota', component: () => import('pages/cadastro/rota/Rota.vue'), meta: { rota: 'rota', requerAutenticacao: true }, props: true },
      { path: '/malotes', name: 'malote', component: () => import('pages/cadastro/malote/Malote.vue'), meta: { rota: 'malote', requerAutenticacao: true } },
      { path: '/malotes/malote/:id', name: 'alterarMalote', component: () => import('pages/cadastro/malote/Malote.vue'), meta: { rota: 'malote', requerAutenticacao: true }, props: true },
      { path: '/correspondencias', name: 'correspondencia', component: () => import('pages/cadastro/correspondencia/Correspondencia.vue'), meta: { rota: 'correspondencia', requerAutenticacao: true } },
      { path: '/correspondencias/correspondencia/:id', name: 'alterarCorrespondencia', component: () => import('pages/cadastro/correspondencia/Correspondencia.vue'), meta: { rota: 'correspondencia', requerAutenticacao: true }, props: true },
      { path: '/tipocobrancas', name: 'tipoCobranca', component: () => import('pages/cadastro/tipoCobranca/TipoCobranca.vue'), meta: { rota: 'tipoCobranca', requerAutenticacao: true } },
      { path: '/tipocobrancas/tipocobranca/:id', name: 'alterarTipoCobranca', component: () => import('pages/cadastro/tipoCobranca/TipoCobranca.vue'), meta: { rota: 'tipoCobranca', requerAutenticacao: true }, props: true }

    ]
  },

  { // Always leave this as last one
    path: '*',
    component: () => import('pages/404')
  }
]

/**
 * {
    path: '/',
    component: () => import('layouts/default'),
    children: [
      { path: '', component: () => import('pages/index') }
    ]
  },

  { // Always leave this as last one
    path: '*',
    component: () => import('pages/404')
  }
 */
