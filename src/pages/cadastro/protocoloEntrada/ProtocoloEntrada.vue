<template>
  <div>
    <bodyTabs titulo="Protocolo de Entrada">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarProtocoloEntrada">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!protocoloEntrada.protocoloEntrada && possoGravarProtocoloEntrada" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="protocoloEntrada.protocoloEntrada && possoAlterarProtocoloEntrada" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirProtocoloEntrada">Excluir</q-btn>
              </div>
              <div class="col-md-6">
                <q-btn small type="button" icon="autorenew" @click="preparaDocSemelhante" v-if="protocoloEntrada.protocoloEntrada">Gravar Doc Semelhante</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <q-field label="Nº"  class="form-input" stack-label>
                  {{protocoloEntrada.anoCadastro+'-'+protocoloEntrada.protocolo}}
                </q-field>
              </div>
              <div class="col-md-4">
                  <form-select
                    label="Tipo de Documento"
                    :error="$v.protocoloEntrada.tipoDocumento.$error"
                    error-message="Obrigatório"
                    classe="form-input"
                    hint="Obrigatório"
                    v-model="protocoloEntrada.tipoDocumento"
                    :options="optionsTipoDocumento"
                    @input="$v.protocoloEntrada.tipoDocumento.$touch()"
                    required
                  />
                  <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-md-3">
                <q-input label="Número"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.protocoloEntrada.numero.$error"
                  error-message="Obrigatório" autocomplete="off" type="text" v-model="protocoloEntrada.numero" @input="$v.protocoloEntrada.numero.$touch()" name="number"/>
              </div>
              <div class="col-md-3">
                <q-input label="Data do documento" class="form-input"
                  hint="Obrigatório" stack-label
                  :error="$v.protocoloEntrada.dataDocumento.$error"
                  error-message="Obrigatório" autocomplete="off" type="date" v-model="protocoloEntrada.dataDocumento" name="data" />
              </div>

            </div>
            <div class="row">
              <div class="col-md-12">
                <q-input
                  label="Assunto"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.protocoloEntrada.assunto.$error"
                  error-message="Obrigatório" autocomplete="on" type="text" v-model="protocoloEntrada.assunto" @input="$v.protocoloEntrada.assunto.$touch()"
                  @change="sugereDestino" name="assunto"
                  />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <q-input label="Origem"
                  hint="Obrigatório"
                  class="form-input"
                  :error="$v.protocoloEntrada.origem.$error"
                  error-message="Obrigatório"
                  autocomplete="on" type="text" v-model="protocoloEntrada.origem" name="origem" >
                </q-input>
              </div>

              <div class="col-md-6">
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
                >
                  <template slot="embutir">
                    <q-popup-proxy>
                      <q-banner @click="protocoloEntrada.setor = destino.setor" cliclable>
                        Sugiro selecionar: {{destino.codigo}}.
                      </q-banner>
                    </q-popup-proxy>
                  </template>
                </form-select>
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
            </div>
          </form>

        </q-tab-panel>
      </template>
    </bodyTabs>
    <lista-de-registros />
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import ListaDeRegistros from './ListaProtocoloEntradas.vue'
import { required } from 'vuelidate/lib/validators'
import ProtocoloEntrada from './ProtocoloEntrada'
import protocoloEntradaService from './ProtocoloEntradaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import Setor from 'src/pages/cadastro/setor/Setor'
import formSelect from 'src/components/form/select/QSelect'
import botService from 'src/services/bot/BotService'
export default {
  name: 'Cadastro-de-ProtocoloEntradas',
  components: {
    BodyTabs,
    ListaDeRegistros,
    formSelect
  },
  data () {
    return {
      protocoloEntrada: new ProtocoloEntrada(),
      tipoDocumento: new TipoDocumento(),
      endereco: new Endereco(),
      setor: new Setor(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarProtocoloEntrada: false,
      possoExcluirProtocoloEntrada: false,
      optionsTipoDocumento: [],
      optionsEndereco: [],
      optionsSetor: [],
      optionsLoading: false,
      timer: '',
      destino: {
        codigo: '',
        setor: ''
      }
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
    sugereDestino () {
      botService.sugereDestino(this.protocoloEntrada.assunto)
        .then(result => {
          if (result.data.length) {
            this.destino.setor = result.data[0].setor
            this.destino.codigo = result.data[0].codigo
          }
        })
    },
    preparaDocSemelhante () {
      this.$v.protocoloEntrada.$reset()
      this.$router.push({name: 'protocoloEntrada'})
      this.possoAlterarProtocoloEntrada = false
      this.possoExcluirProtocoloEntrada = false

      let protocolo = new ProtocoloEntrada(this.protocoloEntrada)
      protocolo.protocolo = ''
      protocolo.protocoloEntrada = ''
      protocolo.numero = ''
      protocolo.usuarioCriador = ''
      protocolo.usuarioAlterador = ''
      this.protocoloEntrada = new ProtocoloEntrada(protocolo)
    },
    parseEnderecos () {
      return this.optionsEndereco.map(endereco => {
        // console.log(endereco)

        return {
          label: endereco.label,
          value: endereco.value
        }
      })
    },
    selected (item) {
      // this.$q.notify(`Selected suggestion "${item.label}"`)
    },
    procuraEndereco (busca) {
      this.$v.protocoloEntrada.origem.$touch()
      console.log(busca)
      console.log('procurando no select')
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
          this.$root.$emit('alteraUnicoRegistro', this.protocoloEntrada)

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
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.$v.protocoloEntrada.$touch()
        if (this.$v.protocoloEntrada.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
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
              console.log(result.data)

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
        }).onOk(() => {
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
  watch: {
    '$route.params.id': {
      handler: function (id) {
        if (id) { this.carrega(id) }
      },
      deep: true,
      immediate: true
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
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsEndereco = this.endereco.setOptions(result.data.endereco)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
      })
  }
}
</script>
