<template>
  <q-layout
    ref="layout"
    view="lHr lpR lFr"
    class="full-height"
  >
    <q-page-container>
      <q-page>
        <bodyTabs titulo="Protocolo de Entrada" :menuDireita="false" :menuEsquerda="false">
          <template slot="tabHeader">
            <!-- Tabs - notice slot="title" -->
            <q-tab name="tab-1" icon="folder_shared" label="Cadastro" />
          </template>
          <template slot="tabPanel">
            <!-- Targets -->
            <q-tab-panel name="tab-1">
              <form @submit.prevent="salvarAlterar">
                <div class="row barraBotoes">
                  <div class="col-md-6 linhaBotoes">
                    <q-btn small type="submit" icon="save" v-if="!protocoloEntrada.protocoloEntrada && possoGravarProtocoloEntrada" >Gravar</q-btn>
                    <q-btn small type="submit" icon="save" v-if="protocoloEntrada.protocoloEntrada && possoAlterarProtocoloEntrada" >Alterar</q-btn>
                  </div>
                </div>
                <div class="col-md-12">
                  <q-field label="Nº" class="form-input" stack-label>
                    {{protocoloEntrada.anoCadastro+'-'+protocoloEntrada.protocolo}}
                  </q-field>
                </div>
                <div class="col-md-12">
                  <q-field
                    class="form-input"
                    label="Importação"
                    stack-label
                  >
                  </q-field>
                  <div class="form-input row">Tipo: {{tipoDocumentoDescricao}}</div>
                  <div class="form-input row">Data: {{dataFormatada}}</div>
                  <div class="form-input row">Origem: {{protocoloEntrada.origem}}</div>
                  <div class="form-input row">Número: {{protocoloEntrada.numero}}</div>
                  <div class="form-input row">
                    Assunto: {{protocoloEntrada.assunto}}
                  </div>
                </div>
                <div class="col-md-12">
                  <form-select
                    class="form-input"
                    :error="$v.protocoloEntrada.setor.$error"
                    error-message="Obrigatório"
                    hint="Obrigatório"
                    classe="form-input"
                    label="Destino"
                    v-model="protocoloEntrada.setor"
                    :options="optionsSetor"
                    @input="$v.protocoloEntrada.setor.$touch()"
                    required
                    autoFocus
                  />
                  <q-linear-progress indeterminate v-show="optionsLoading"/>
                </div>
              </form>
            </q-tab-panel>
          </template>
        </bodyTabs>
      </q-page>
    </q-page-container>
    <!-- <q-resize-observer @resize="onResize" /> -->
  </q-layout>

</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import dayJs from 'dayjs'
import { required } from 'vuelidate/lib/validators'
import ProtocoloEntrada from './ProtocoloEntrada'
import protocoloEntradaService from './ProtocoloEntradaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import Setor from 'src/pages/cadastro/setor/Setor'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import formSelect from 'src/components/form/select/QSelect'

export default {
  name: 'ProtocoloEntradas-Extensao',
  components: {
    BodyTabs,
    formSelect
  },
  data () {
    return {
      timer: '',
      json: '',
      protocoloEntrada: new ProtocoloEntrada(),
      setor: new Setor(),
      tipoDocumento: new TipoDocumento(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarProtocoloEntrada: false,
      possoExcluirProtocoloEntrada: false,
      optionsSetor: [],
      optionsTipoDocumento: [],
      optionsLoading: false
    }
  },
  validations: {
    protocoloEntrada: {
      tipoDocumento: {required},
      numero: {required},
      dataDocumento: {required},
      origem: {required},
      assunto: {required},
      setor: {required}
    }
  },
  methods: {
    preencheJson () {
      let dados = ''
      try {
        dados = JSON.parse(this.json)
      } catch (e) {
        return false
      }
      this.protocoloEntrada.assunto = dados.assunto
      this.protocoloEntrada.dataDocumento = dados.dataDocumento
      this.protocoloEntrada.numero = dados.numero
      this.protocoloEntrada.origem = dados.origem
      this.protocoloEntrada.tipoDocumento = dados.tipoDocumento
    },
    reset () {
      this.$v.protocoloEntrada.$reset()
      this.protocoloEntrada = new ProtocoloEntrada()
      this.json = ''
      this.possoAlterarProtocoloEntrada = false
      this.possoExcluirProtocoloEntrada = false
    },
    salvarAlterar () {
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.$v.protocoloEntrada.$touch()
        if (this.$v.protocoloEntrada.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          console.log('validador ', this.$v.protocoloEntrada)
          console.log('this.pro ', this.protocoloEntrada)
          return
        }

        protocoloEntradaService.grava(this.protocoloEntrada)
          .then(result => {
            console.log('protocoloEntrada criado com sucesso')
            console.log(result.data)

            protocoloEntradaService
              .seleciona(result.data.protocoloEntrada.protocoloEntrada)
              .then(result => {
                this.$q.loading.hide()
                this.protocoloEntrada = Object.assign({}, this.protocoloEntrada, result.data)
                this.$q.notify({
                  type: 'positive',
                  message: 'Protocolo de Entrada criado com sucesso.',
                  timeout: 5000
                })
                this.confereAlterarExcluir()
              })
          })
      }, 2000)
    },
    confereAlterarExcluir () {
      this.possoAlterarProtocoloEntrada = permissoes.alterar('protocoloEntrada', this.protocoloEntrada.usuarioCriador)
      this.possoExcluirProtocoloEntrada = permissoes.excluir('protocoloEntrada', this.protocoloEntrada.usuarioCriador)
    }
  },
  computed: {
    possoGravarProtocoloEntrada: () => permissoes.gravar('protocoloEntrada'),
    dataFormatada: function () {
      if (this.protocoloEntrada.dataDocumento !== '') {
        return dayJs(this.protocoloEntrada.dataDocumento).format('DD/MM/YYYY')
      }
      return ''
    },
    tipoDocumentoDescricao: function () {
      let descricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.protocoloEntrada.tipoDocumento)
      console.log(descricao)
      if (descricao.length !== 0) {
        return descricao[0].label
      }
      return ''
    }
  },
  created () {
    this.optionsLoading = true
    protocoloEntradaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
      })
  },
  mounted () {
    this.$chrome.storage.sync.get(['protocoloEntrada'], (result) => {
      console.log('result ', result)
      console.log('result.protocoloEntrada ', result.protocoloEntrada)
      this.protocoloEntrada.assunto = result.protocoloEntrada.assunto
      this.protocoloEntrada.dataDocumento = result.protocoloEntrada.dataDocumento
      this.protocoloEntrada.numero = result.protocoloEntrada.numero
      this.protocoloEntrada.origem = result.protocoloEntrada.origem
      this.protocoloEntrada.tipoDocumento = result.protocoloEntrada.tipoDocumento
      console.log('this.protocoloEntrada ', this.protocoloEntrada)
      this.json = JSON.stringify(result.protocoloEntrada)
    })
  }
}
</script>
