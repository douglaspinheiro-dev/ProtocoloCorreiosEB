<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <q-toolbar-title>Protocolo de Entrada</q-toolbar-title>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted>
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="fas fa-file-contract" label="Cadastro"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="submit" icon="save" v-if="!protocoloEntrada.protocoloEntrada && possoGravarProtocoloEntrada" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="protocoloEntrada.protocoloEntrada && possoAlterarProtocoloEntrada" >Alterar</q-btn>
              </div>
            </div>
            <div class="col-md-12">
              <q-field label="Nº" orientation="vertical" class="form-input">
                {{protocoloEntrada.anoCadastro+'-'+protocoloEntrada.protocolo}}
              </q-field>
            </div>
            <div class="col-md-12">
              <q-field
                class="form-input"
                label="Importação"
                orientation="vertical"
              >
                <div class="row">

                  <div class="col-6">Tipo: {{tipoDocumentoDescricao}}</div>
                  <div class="col-6">Data: {{dataFormatada}}</div>
                </div>
                <div class="row">
                  <div class="col-6">Origem: {{protocoloEntrada.origem}}</div>
                  <div class="col-6">Número: {{protocoloEntrada.numero}}</div>
                </div>
                <div class="row">
                  Assunto: {{protocoloEntrada.assunto}}
                </div>
              </q-field>
            </div>
            <div class="col-md-12">
              <q-field class="form-input" label="Destino" orientation="vertical"
                :error="$v.protocoloEntrada.setor.$error"
                error-label="Obrigatório"
                helper="Obrigatório"
              >
                <q-select
                  v-model="protocoloEntrada.setor"
                  :options="optionsSetor"
                  filter
                  autofocus-filter
                  filter-placeholder="Selecione o Destino"
                  name="select"
                  @input="$v.protocoloEntrada.setor.$touch()"
                  autofocus
                />
                <q-progress indeterminate v-show="optionsLoading"/>
              </q-field>
            </div>
          </form>
        </q-page>
      </q-tab-pane>
    </q-tabs>
  </div>
</template>

<script>
import dayJs from 'dayjs'
import { required } from 'vuelidate/lib/validators'
import ProtocoloEntrada from 'src/services/protocoloEntrada/ProtocoloEntrada'
import protocoloEntradaService from 'src/services/protocoloEntrada/ProtocoloEntradaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import Setor from 'src/services/setor/Setor'
import TipoDocumento from 'src/services/tipoDocumento/TipoDocumento'
var timer

export default {
  name: 'ProtocoloEntradas-Extensao',
  data () {
    return {
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
      clearTimeout(timer)
      timer = setTimeout(() => {
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
    this.optionsLoading = true
    protocoloEntradaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
      })
  }
}
</script>
