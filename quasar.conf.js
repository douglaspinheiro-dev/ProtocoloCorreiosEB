// Configuration for your app

module.exports = function (ctx) {
  return {
    // app plugins (/src/plugins)
    plugins: [
      'axios',
      'vuelidate'
    ],
    css: [
      'app.styl'
    ],
    extras: [
      ctx.theme.mat ? 'roboto-font' : null,
      'material-icons', // optional, you are not bound to it
      // 'ionicons',
      // 'mdi',
      'fontawesome'
    ],
    supportIE: false,
    build: {
      scopeHoisting: true,
      vueRouterMode: 'hash',
      // vueCompiler: true,
      // gzip: true,
      // analyze: true,
      // extractCSS: false,
      extendWebpack (cfg) {
        cfg.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules|quasar)/
        })
      },
      sourceMap: false,
      minify: true,
      webpackManifest: true,
      env: ctx.dev
        ? { // so on dev we'll have
          API: JSON.stringify('http://localhost:8000')
        }
        : { // and on build (production):
          API: JSON.stringify('http://10.1.11.242/sysprot/api')
        }
    },
    devServer: {
      // https: true,
      // port: 8080,
      open: true // opens browser window automatically
    },
    // framework: 'all' --- includes everything; for dev only!
    framework: {
      components: [
        'QAutocomplete',
        'QBtn',
        'QBtnGroup',
        'QCard',
        'QCardActions',
        'QCardMain',
        'QCardMedia',
        'QCardSeparator',
        'QCardTitle',
        'QCollapsible',
        'QDialog',
        'QFab',
        'QFabAction',
        'QField',
        'QIcon',
        'QInfiniteScroll',
        'QInnerLoading',
        'QInput',
        'QItem',
        'QItemMain',
        'QItemSeparator',
        'QItemSide',
        'QItemTile',
        'QLayout',
        'QLayoutDrawer',
        'QLayoutFooter',
        'QLayoutHeader',
        'QList',
        'QListHeader',
        'QModal',
        'QModalLayout',
        'QOptionGroup',
        'QPage',
        'QPageContainer',
        'QPageSticky',
        'QPopover',
        'QRouteTab',
        'QScrollArea',
        'QSearch',
        'QSelect',
        'QSpinnerDots',
        'QSpinnerGears',
        'QStep',
        'QStepper',
        'QStepperNavigation',
        'QTab',
        'QTabPane',
        'QTable',
        'QTabs',
        'QTd',
        'QTr',
        'QTh',
        'QToolbar',
        'QToolbarTitle',
        'QTooltip',
        'QToggle',
        'QBtnToggle',
        'QRadio',
        'QTableColumns',
        'QProgress',
        'QAjaxBar',
        'QPopupEdit',
        'QBtnDropdown'
      ],
      directives: [
        'Ripple',
        'CloseOverlay'
      ],
      // Quasar plugins
      plugins: [
        'Notify',
        'Loading',
        'Dialog'
      ]
      // iconSet: ctx.theme.mat ? 'material-icons' : 'ionicons'
      // i18n: 'de' // Quasar language
    },
    // animations: 'all' --- includes all animations
    animations: [
    ],
    pwa: {
      // workboxPluginMode: 'InjectManifest',
      // workboxOptions: {},
      manifest: {
        name: 'Informáticos Eventos',
        short_name: 'Info-Eventos',
        description: 'Sistema Web',
        display: 'standalone',
        orientation: 'portrait',
        background_color: '#ffffff',
        theme_color: '#027be3',
        icons: [
          {
            'src': 'statics/icons/icon-128x128.png',
            'sizes': '128x128',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-192x192.png',
            'sizes': '192x192',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-256x256.png',
            'sizes': '256x256',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-384x384.png',
            'sizes': '384x384',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-512x512.png',
            'sizes': '512x512',
            'type': 'image/png'
          }
        ]
      }
    },
    cordova: {
      // id: 'org.cordova.quasar.app'
    },
    electron: {
      // bundler: 'builder', // or 'packager'
      extendWebpack (cfg) {
        // do something with Electron process Webpack cfg
      },
      packager: {
        // https://github.com/electron-userland/electron-packager/blob/master/docs/api.md#options

        // OS X / Mac App Store
        // appBundleId: '',
        // appCategoryType: '',
        // osxSign: '',
        // protocol: 'myapp://path',

        // Window only
        // win32metadata: { ... }
      },
      builder: {
        // https://www.electron.build/configuration/configuration

        // appId: 'quasar-app'
      }
    }
  }
}
