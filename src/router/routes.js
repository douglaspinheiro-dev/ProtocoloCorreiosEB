
export default [
  { path: '/', component: () => import('pages/login') },
  { path: '/consulta', component: () => import('pages/consultaCorrespondencia') },
  {
    path: '/root',
    component: () => import('layouts/root'),
    name: 'layoutRoot',
    meta: { requerAutenticacao: true },
    children: [
      { path: '/dashboard', name: 'dashboard', component: () => import('pages/dashboard/dashboard'), meta: { requerAutenticacao: true } },
      { path: '/dashboard/:primeiroLogin', name: 'dashboardPrimeiroLogin', component: () => import('pages/dashboard/dashboard'), meta: { requerAutenticacao: true }, props: true },
      { path: '/grupousuarios', name: 'grupoUsuario', component: () => import('pages/sistema/GrupoUsuario'), meta: { requerAutenticacao: true } },
      { path: '/grupousuarios/grupousuario/:id', name: 'alterarGrupoUsuario', component: () => import('pages/sistema/GrupoUsuario'), meta: { requerAutenticacao: true }, props: true },
      { path: '/usuarios', name: 'usuario', component: () => import('pages/sistema/Usuario'), meta: { requerAutenticacao: true } },
      { path: '/usuarios/usuario/:id', name: 'alterarUsuario', component: () => import('pages/sistema/Usuario'), meta: { requerAutenticacao: true }, props: true },
      { path: '/tipodocumentos', name: 'tipoDocumento', component: () => import('pages/cadastro/TipoDocumento'), meta: { requerAutenticacao: true } },
      { path: '/tipodocumentos/tipodocumento/:id', name: 'alterarTipoDocumento', component: () => import('pages/cadastro/TipoDocumento'), meta: { requerAutenticacao: true }, props: true },
      { path: '/tipocorrespondencias', name: 'tipoCorrespondencia', component: () => import('pages/cadastro/TipoCorrespondencia'), meta: { requerAutenticacao: true } },
      { path: '/tipocorrespondencias/tipocorrespondencia/:id', name: 'alterarTipoCorrespondencia', component: () => import('pages/cadastro/TipoCorrespondencia'), meta: { requerAutenticacao: true }, props: true },
      { path: '/enderecos', name: 'endereco', component: () => import('pages/cadastro/Endereco'), meta: { requerAutenticacao: true } },
      { path: '/enderecos/endereco/:id', name: 'alterarEndereco', component: () => import('pages/cadastro/Endereco'), meta: { requerAutenticacao: true }, props: true },
      { path: '/setores', name: 'setor', component: () => import('pages/cadastro/Setor'), meta: { requerAutenticacao: true } },
      { path: '/setores/setor/:id', name: 'alterarSetor', component: () => import('pages/cadastro/Setor'), meta: { requerAutenticacao: true }, props: true },
      { path: '/protocoloentradas', name: 'protocoloEntrada', component: () => import('pages/cadastro/ProtocoloEntrada'), meta: { requerAutenticacao: true } },
      { path: '/protocoloentradas/extensao', name: 'protocoloEntradaExtensao', component: () => import('pages/cadastro/ProtocoloEntradaExtensao'), meta: { requerAutenticacao: true } },
      { path: '/protocoloentradas/protocoloentrada/:id', name: 'alterarProtocoloEntrada', component: () => import('pages/cadastro/ProtocoloEntrada'), meta: { requerAutenticacao: true }, props: true },
      { path: '/rotas', name: 'rota', component: () => import('pages/cadastro/Rota'), meta: { requerAutenticacao: true } },
      { path: '/rotas/rota/:id', name: 'alterarRota', component: () => import('pages/cadastro/Rota'), meta: { requerAutenticacao: true }, props: true },
      { path: '/malotes', name: 'malote', component: () => import('pages/cadastro/Malote'), meta: { requerAutenticacao: true } },
      { path: '/malotes/malote/:id', name: 'alterarMalote', component: () => import('pages/cadastro/Malote'), meta: { requerAutenticacao: true }, props: true },
      { path: '/correspondencias', name: 'correspondencia', component: () => import('pages/cadastro/Correspondencia'), meta: { requerAutenticacao: true } },
      { path: '/correspondencias/correspondencia/:id', name: 'alterarCorrespondencia', component: () => import('pages/cadastro/Correspondencia'), meta: { requerAutenticacao: true }, props: true },
      { path: '/tipocobrancas', name: 'tipoCobranca', component: () => import('pages/cadastro/TipoCobranca'), meta: { requerAutenticacao: true } },
      { path: '/tipocobrancas/tipocobranca/:id', name: 'alterarTipoCobranca', component: () => import('pages/cadastro/TipoCobranca'), meta: { requerAutenticacao: true }, props: true }

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
