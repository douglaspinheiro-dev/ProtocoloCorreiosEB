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
              <div class="col-sm-12 col-xs-12 col-md-2">
                <q-field label="Nº"  class="form-input" stack-label>
                  {{protocoloEntrada.anoCadastro+'-'+protocoloEntrada.protocolo}}
                </q-field>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-2">
                <q-input label="Identificador"
                  class="form-input"
                  autocomplete="off" type="tel" v-model="protocoloEntrada.identificador" name="number"/>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-3">
                  <form-select
                    label="Tipo de Documento"
                    :error="$v.protocoloEntrada.tipoDocumento.$error"
                    error-message="Obrigatório"
                    required
                    hint="Obrigatório"
                    classe="form-input"
                    v-model="protocoloEntrada.tipoDocumento"
                    :options="optionsTipoDocumento"
                    @input="$v.protocoloEntrada.tipoDocumento.$touch()"
                  />
                  <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-2">
                <q-input label="Número"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.protocoloEntrada.numero.$error"
                  error-message="Obrigatório" autocomplete="off" type="text" v-model="protocoloEntrada.numero" @input="$v.protocoloEntrada.numero.$touch()" name="number"/>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-3">
                <q-input label="Data do documento" class="form-input"
                  hint="Obrigatório" stack-label
                  :error="$v.protocoloEntrada.dataDocumento.$error"
                  error-message="Obrigatório" autocomplete="off" type="date" v-model="protocoloEntrada.dataDocumento" name="data" />
              </div>

            </div>
            <div class="row">
              <div class="col-sm-12 col-xs-12 col-md-12">
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
              <div class="col-sm-12 col-xs-12 col-md-6">
                <q-input label="Origem"
                  hint="Obrigatório"
                  class="form-input"
                  :error="$v.protocoloEntrada.origem.$error"
                  error-message="Obrigatório"
                  autocomplete="on" type="text" v-model="protocoloEntrada.origem" name="origem" >
                </q-input>
              </div>

              <div class="col-sm-12 col-xs-12 col-md-6">
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
                  <!-- <template slot="embutir">
                    <q-popup-proxy>

                    /q-popup-proxy>
                  </template> -->
                </form-select>
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
            </div>
            <div class="row">
              <!-- <q-banner v-show="destinos.length">
                Destinos Frequentes:.
                <ul v-for="destino in destinos" :key="destino.setor">
                  <li @click="protocoloEntrada.setor = destino.setor">{{destino.codigo}}</li>
                </ul>
              </q-banner> -->
              <div class="col-12" v-show="destinos.length">
                Destinos Frequentes:
                <q-list bordered separator v-for="destino in destinos" :key="destino.setor">
                  <q-item clickable v-ripple @click="protocoloEntrada.setor = destino.setor">
                    <q-item-section>{{destino.codigo}}</q-item-section>
                  </q-item>
                </q-list>
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
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import Setor from 'src/pages/cadastro/setor/Setor'
import formSelect from 'src/components/form/select/QSelect'
import botService from 'src/services/bot/BotService'
import tools from 'src/tools'

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
      destinos: [],
      destino: {
        codigo: '',
        setor: ''
      }
    }
  },
  validations: {
    protocoloEntrada: {
      tipoDocumento: { required },
      numero: { required },
      dataDocumento: { required },
      origem: { required },
      assunto: { required },
      setor: { required }
    }
  },
  methods: {
    sugereDestino () {
      botService.sugereDestino(this.protocoloEntrada.assunto)
        .then(result => {
          if (result.data.length) {
            this.protocoloEntrada.setor = result.data[0].setor
            this.destinos = result.data
          }
        })
    },
    preparaDocSemelhante () {
      this.$v.protocoloEntrada.$reset()
      this.$router.push({ name: 'protocoloEntrada' })
      this.possoAlterarProtocoloEntrada = false
      this.possoExcluirProtocoloEntrada = false

      const protocolo = new ProtocoloEntrada(this.protocoloEntrada)
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
      this.$router.push({ name: 'protocoloEntrada' })
      this.possoAlterarProtocoloEntrada = false
      this.possoExcluirProtocoloEntrada = false
      this.destinos = []
    },
    carrega (id) {
      this.destinos = []
      console.log('vou carregar o protocoloEntrada')
      tools.Loadings.processando()

      protocoloEntradaService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o protocoloEntrada com sucesso')
          this.protocoloEntrada = Object.assign({}, this.protocoloEntrada, result.data)

          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.protocoloEntrada.$touch()
      if (this.$v.protocoloEntrada.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.protocoloEntrada.protocoloEntrada && this.possoAlterarProtocoloEntrada) {
          console.log('estou alterando o form')
          protocoloEntradaService.altera(this.protocoloEntrada)
            .then(result => {
              tools.Loadings.hide()
              console.log('protocoloEntrada alterado com sucesso')
              const tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.protocoloEntrada.tipoDocumento)
              this.protocoloEntrada.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.protocoloEntrada,
                id: 'protocoloEntrada'
              })

              tools.Notify.positive('Protocolo de Entrada alterado com sucesso.')
            })
        } else if (!this.protocoloEntrada.protocoloEntrada && this.possoGravarProtocoloEntrada) {
          protocoloEntradaService.grava(this.protocoloEntrada)
            .then(result => {
              console.log('protocoloEntrada criado com sucesso')
              console.log(result.data)

              this.protocoloEntrada.protocoloEntrada = result.data.protocoloEntrada.protocoloEntrada
              this.protocoloEntrada.usuarioCriador = result.data.protocoloEntrada.usuarioCriador
              this.$router.push('/protocoloEntradas/protocoloEntrada/' + result.data.protocoloEntrada.protocoloEntrada)
              tools.Notify.positive('Protocolo de Entrada criado com sucesso.')

              const tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.protocoloEntrada.tipoDocumento)
              this.protocoloEntrada.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.protocoloEntrada)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
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
          tools.Loadings.processando()

          protocoloEntradaService.apaga(this.protocoloEntrada.protocoloEntrada)
            .then(result => {
              tools.Loadings.hide()
              console.log('protocoloEntrada removido com sucesso')
              tools.Notify.negative('Protocolo de Entrada removido com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.protocoloEntrada.protocoloEntrada,
                id: 'protocoloEntrada'
              })
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
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
        if (id) {
          this.carrega(id)
        }
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
