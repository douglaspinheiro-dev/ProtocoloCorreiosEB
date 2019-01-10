<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Protocolo de Entrada</q-toolbar-title>
        <botao-menu-right/>
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarProtocoloEntrada">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!protocoloEntrada.protocoloEntrada && possoGravarProtocoloEntrada" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="protocoloEntrada.protocoloEntrada && possoAlterarProtocoloEntrada" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirProtocoloEntrada">Excluir</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <q-field label="Nº" orientation="vertical" class="form-input">
                  {{protocoloEntrada.anoCadastro+'-'+protocoloEntrada.protocolo}}
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Tipo de Documento" orientation="vertical"
                  :error="$v.protocoloEntrada.tipoDocumento.$error"
                  error-label="Obrigatório"
                  helper="Obrigatório"
                >
                  <q-select
                    v-model="protocoloEntrada.tipoDocumento"
                    :options="optionsTipoDocumento"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o Tipo de Documento"
                    name="select"
                    @input="$v.protocoloEntrada.tipoDocumento.$touch()"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>
              <div class="col-md-3">
                <q-field
                  label="Número"
                  orientation="vertical"
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.numero.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="off" type="text" v-model="protocoloEntrada.numero" @input="$v.protocoloEntrada.numero.$touch()" name="number"/>
                </q-field>
              </div>
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Data do documento"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.dataDocumento.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="off" type="date" v-model="protocoloEntrada.dataDocumento" name="data" />
                </q-field>
              </div>

            </div>
            <div class="row">
              <div class="col-md-4">
                <q-field class="form-input" label="É endereço cadastrado?" orientation="vertical">
                  <q-btn-group  class="fit">
                    <radio-button :status="protocoloEntrada.enderecoCadastrado"
                    @toggleRadioButton="protocoloEntrada.enderecoCadastrado = !protocoloEntrada.enderecoCadastrado"
                    :label="['Sim','Não']"
                  />
                  </q-btn-group>
                </q-field>
              </div>

              <!-- <div class="col-md-8" v-show="enderecoCadastrado">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.origem.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="protocoloEntrada.origem"
                    :options="optionsEndereco"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione a Origem"
                    name="select"
                    @input="procuraEndereco"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div> -->

              <div class="col-md-8" v-show="protocoloEntrada.enderecoCadastrado">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.origem.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="on" type="text" v-model="protocoloEntrada.origem" name="origem" >
                    <q-autocomplete
                      @search="search"
                      :min-characters="3"
                      @selected="selected"
                    />
                  </q-input>
                </q-field>
              </div>

              <div class="col-md-8" v-show="!protocoloEntrada.enderecoCadastrado">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.origem.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="on" type="text" v-model="protocoloEntrada.origem" name="origem" >
                    <!-- <q-autocomplete
                      @search="search"
                      :min-characters="3"
                      @selected="selected"
                    /> -->
                  </q-input>
                </q-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <q-field
                  label="Assunto"
                  orientation="vertical"
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.protocoloEntrada.assunto.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="on" type="text" v-model="protocoloEntrada.assunto" @input="$v.protocoloEntrada.assunto.$touch()" name="assunto"/>
                </q-field>
              </div>
            </div>
            <div class="row">
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
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>
            </div>
          </form>

          <botao-mobile
            :id="protocoloEntrada.protocoloEntrada"
            :possoGravar="possoGravarProtocoloEntrada"
            :possoAlterar="possoAlterarProtocoloEntrada"
            :possoExcluir="possoExcluirProtocoloEntrada"
            @salvarAlterar="salvarAlterar"
            @excluir="excluir"
            @reset="reset"
          />

        </q-page>
      </q-tab-pane>
    </q-tabs>
    <lista-de-registros/>
  </div>
</template>

<script>
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'
import RadioButton from 'src/components/form/radios/RadioButton'
import ListaDeRegistros from 'src/components/menuRight/ListaProtocoloEntradas.vue'
import { required } from 'vuelidate/lib/validators'
import ProtocoloEntrada from 'src/services/protocoloEntrada/ProtocoloEntrada'
import protocoloEntradaService from 'src/services/protocoloEntrada/ProtocoloEntradaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
import { filter } from 'quasar'
var timer

export default {
  name: 'Cadastro-de-ProtocoloEntradas',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    RadioButton,
    botaoMobile
  },
  data () {
    return {
      protocoloEntrada: new ProtocoloEntrada(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarProtocoloEntrada: false,
      possoExcluirProtocoloEntrada: false,
      optionsTipoDocumento: [],
      enderecoCadastrado: true,
      optionsEndereco: [],
      optionsSetor: [],
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
    parseEnderecos () {
      return this.optionsEndereco.map(endereco => {
        // console.log(endereco)

        return {
          label: endereco.label,
          value: endereco.value
        }
      })
    },
    search (terms, done) {
      setTimeout(() => {
        done(filter(terms, {field: 'value', list: this.parseEnderecos()}))
      }, 1000)
    },
    selected (item) {
      // this.$q.notify(`Selected suggestion "${item.label}"`)
    },
    procuraEndereco (busca) {
      this.$v.protocoloEntrada.origem.$touch()
      console.log(busca)
      console.log('procurando no select')
    },

    setOptionsTipoDocumento (tipoDocumentos) {
      if (tipoDocumentos.length > 0) {
        let optionsTipoDocumento = []
        tipoDocumentos.map(tipoDocumento => optionsTipoDocumento.push(
          {
            label: tipoDocumento.descricao,
            value: tipoDocumento.tipoDocumento
          }
        ))
        this.optionsTipoDocumento = optionsTipoDocumento
      } else {
        this.optionsTipoDocumento = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    setOptionsEndereco (enderecos) {
      if (enderecos.length > 0) {
        let optionsEndereco = []
        enderecos.map(endereco => optionsEndereco.push(
          {
            label: `${endereco.codigoReduzido} - ${endereco.descricao}`,
            value: endereco.codigoReduzido
          }
        ))
        this.optionsEndereco = optionsEndereco
      } else {
        this.optionsEndereco = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    setOptionsSetor (setores) {
      if (setores.length > 0) {
        let optionsSetor = []
        setores.map(setor => optionsSetor.push(
          {
            label: `${setor.codigoReduzido} - ${setor.descricao}`,
            value: setor.setor
          }
        ))
        this.optionsSetor = optionsSetor
      } else {
        this.optionsSetor = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    toggleRadioButton () {
      this.protocoloEntrada.status = !this.protocoloEntrada.status
    },
    reset () {
      this.$v.protocoloEntrada.$reset()
      this.protocoloEntrada = new ProtocoloEntrada()
      this.$router.push({name: 'protocoloEntrada'})
      this.possoAlterarProtocoloEntrada = false
      this.possoExcluirProtocoloEntrada = false
    },
    carrega (id) {
      console.log('vou carregar o protocoloEntrada')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      protocoloEntradaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o protocoloEntrada com sucesso')
          this.protocoloEntrada = Object.assign({}, this.protocoloEntrada, result.data)
          this.confereAlterarExcluir()
        })
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
          return
        }

        if (this.protocoloEntrada.protocoloEntrada && this.possoAlterarProtocoloEntrada) {
          console.log('estou alterando o form')
          protocoloEntradaService.altera(this.protocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('protocoloEntrada alterado com sucesso')
              let tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.protocoloEntrada.tipoDocumento)
              this.protocoloEntrada.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$root.$emit('alteraUnicoRegistro', this.protocoloEntrada)
              this.$q.notify({
                type: 'positive',
                message: 'Protocolo de Entrada alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.protocoloEntrada.protocoloEntrada && this.possoGravarProtocoloEntrada) {
          protocoloEntradaService.grava(this.protocoloEntrada)
            .then(result => {
              console.log('protocoloEntrada criado com sucesso')
              this.protocoloEntrada.protocoloEntrada = result.data.protocoloEntrada.protocoloEntrada
              this.protocoloEntrada.usuarioCriador = result.data.protocoloEntrada.usuarioCriador
              this.$router.push('/protocoloEntradas/protocoloEntrada/' + result.data.protocoloEntrada.protocoloEntrada)
              this.$q.notify({
                type: 'positive',
                message: 'Protocolo de Entrada criado com sucesso.',
                timeout: 5000
              })
              let tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.protocoloEntrada.tipoDocumento)
              this.protocoloEntrada.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$root.$emit('adicionaRegistroNaLista', this.protocoloEntrada)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirProtocoloEntrada) {
        this.$q.dialog({
          title: 'Tem certeza?',
          message: 'Ao confirmar esta operação, não poderá desfazer.',
          ok: 'Sim, excluir',
          cancel: 'Cancelar'
        }).then(() => {
          this.$q.loading.show({
            message: 'Processando sua requisição',
            messageColor: 'white',
            spinnerSize: 250, // in pixels
            spinnerColor: 'white'
          })

          protocoloEntradaService.apaga(this.protocoloEntrada.protocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('protocoloEntrada removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Protocolo de Entrada removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.protocoloEntrada.protocoloEntrada)
              this.reset()
            })
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
      } else {
        notify.semPermissao()
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarProtocoloEntrada = permissoes.alterar('protocoloEntrada', this.protocoloEntrada.usuarioCriador)
      this.possoExcluirProtocoloEntrada = permissoes.excluir('protocoloEntrada', this.protocoloEntrada.usuarioCriador)
    }
  },
  props: {
    id: {}
  },
  watch: {
    id: function (id) {
      if (id) { this.carrega(id) }
    }
  },
  computed: {
    possoGravarProtocoloEntrada: () => permissoes.gravar('protocoloEntrada')
  },
  mounted () {
    this.optionsLoading = true
    protocoloEntradaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsTipoDocumento(result.data.tipoDocumento)
        this.setOptionsEndereco(result.data.endereco)
        this.setOptionsSetor(result.data.setor)
      })
  }
}
</script>
