// Configuration for your app

module.exports = function (ctx) {
  return {
    // app boot (/src/boot)
    boot: [
      'axios',
      'vuelidate',
      'chrome'
    ],
    css: [
      'app.styl'
    ],
    extras: [
      'material-icons', // optional, you are not bound to it
      // 'ionicons-v4',
      // 'mdi-v3',
      'fontawesome-v5'
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

        cfg.module.rules.push({
          // fixes https://github.com/graphql/graphql-js/issues/1272
          test: /\.mjs$/,
          include: /node_modules/,
          type: 'javascript/auto'
        })
        if (!ctx.dev) {
          // DESATIVANDO PARA COLOCAR FRONT DENTRO DA API
          const CopyWebpackPlugin = require('copy-webpack-plugin')
          cfg.plugins.push(
            new CopyWebpackPlugin({
              patterns: [
                {
                  from: './api/captain-definition',
                  to: '../../api/build/captain-definition',
                  toType: 'file'
                }
              ]
            })
          )

          // const TarGzPlugin = require('webpack-tar-gz-plugin')
          // cfg.plugins.push(
          //   new TarGzPlugin(tarGzStream => {
          //     tarGzStream.pipe(require('fs').createWriteStream('./dist/web.tar.gz'))
          //   })
          // )

          const FileManagerPlugin = require('filemanager-webpack-plugin')
          cfg.plugins.push(
            new FileManagerPlugin({
              onEnd: [
                {
                  delete: [
                    './api/public/pdf/*.*'
                  ]
                },
                {
                  copy: [
                    { source: './api/deploy', destination: './api/build/deploy' },
                    { source: './api/app', destination: './api/build/app' },
                    { source: './api/bootstrap', destination: './api/build/bootstrap' },
                    { source: './api/config', destination: './api/build/config' },
                    { source: './api/database', destination: './api/build/database' },
                    { source: './api/database', destination: './api/build/database' },
                    { source: './api/public', destination: './api/build/public' },
                    { source: './dist/spa', destination: './api/build/public/web' },
                    { source: './api/resources', destination: './api/build/resources' },
                    { source: './api/routes', destination: './api/build/routes' },
                    { source: './api/storage', destination: './api/build/storage' },
                    { source: './api/tests', destination: './api/build/tests' },
                    { source: './api/.styleci.yml', destination: './api/build/' },
                    { source: './api/artisan', destination: './api/build/' },
                    { source: './api/composer.json', destination: './api/build/' },
                    { source: './api/composer.lock', destination: './api/build/' },
                    { source: './api/phpunit.xml', destination: './api/build/' }
                  ]
                },
                {
                  delete: [
                    './dist/**.*'
                  ]
                },
                {
                  archive: [
                    {
                      source: './api/build',
                      destination: './dist/api.tar.gz',
                      format: 'tar',
                      options: {
                        gzip: true,
                        gzipOptions: {
                          level: 1
                        },
                        globOptions: {
                          nomount: true
                        }
                      }
                    }
                  ]
                },
                {
                  delete: [
                    './dist/spa',
                    './api/build/'
                  ]
                }
              ]
            })
          )
        }
      },
      sourceMap: false,
      minify: true,
      webpackManifest: true,
      env: ctx.dev
        ? { // so on dev we'll have
          API: JSON.stringify('http://localhost:80/api')
        }
        : { // and on build (production):
          API: JSON.stringify('http://10.1.9.21/api')
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
        'QBtn',
        'QBtnGroup',
        'QCard',
        'QCardActions',
        'QCardSection',
        'QSeparator',
        'QExpansionItem',
        'QDialog',
        'QFab',
        'QFabAction',
        'QField',
        'QIcon',
        'QInfiniteScroll',
        'QInnerLoading',
        'QInput',
        'QItem',
        'QItemLabel',
        'QSeparator',
        'QItemSection',
        'QLayout',
        'QDrawer',
        'QFooter',
        'QHeader',
        'QList',
        'QItemLabel',
        'QOptionGroup',
        'QPage',
        'QPageContainer',
        'QPageSticky',
        'QMenu',
        'QRouteTab',
        'QScrollArea',
        'QSelect',
        'QSpinnerDots',
        'QSpinnerGears',
        'QStep',
        'QStepper',
        'QStepperNavigation',
        'QTab',
        'QTabPanels',
        'QTabPanel',
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
        'QLinearProgress',
        'QAjaxBar',
        'QPopupEdit',
        'QBtnDropdown',
        'QLinearProgress',
        'QPopupProxy',
        'QBanner',
        'QImg'
      ],
      directives: [
        'Ripple',
        'ClosePopup'
      ],
      // Quasar plugins
      plugins: [
        'Notify',
        'Loading',
        'Dialog'
      ]
      // lang: 'de' // Quasar language
    },
    // animations: 'all' --- includes all animations
    animations: [],
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
        icons: [{
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
