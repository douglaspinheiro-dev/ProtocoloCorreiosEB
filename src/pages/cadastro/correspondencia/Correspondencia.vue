<template>
  <div>
    <bodyTabs titulo="Cadastro de Correspondências">
      <template slot="tabHeader">
        <q-tab name="tab-1" icon="folder_shared" label="Cadastro" />
      </template>
      <template slot="tabPanel">
        <q-tab-panel name="tab-1">
          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarCorrespondencia">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!correspondencia.correspondencia && possoGravarCorrespondencia" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="correspondencia.correspondencia && possoAlterarCorrespondencia" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirCorrespondencia">Excluir</q-btn>
              </div>
              <div class="col-md-6">
                <q-btn small type="button" icon="autorenew" @click="preparaDocSemelhante" v-if="correspondencia.correspondencia">Gravar Doc Semelhante</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <q-field label="Nº"  class="form-input" stack-label>
                  {{correspondencia.anoCadastro+'-'+correspondencia.protocolo}}
                </q-field>
              </div>
              <div class="col-md-3">
                <q-input class="form-input"
                  label="Data do cadastro"
                  hint="Obrigatório"
                  :error="$v.correspondencia.dataCadastro.$error"
                  error-message="Obrigatório" autocomplete="off" type="date" v-model="correspondencia.dataCadastro" name="data" />
              </div>
              <div class="col-md-4">
                <form-select
                  :error="$v.correspondencia.tipoDocumento.$error"
                  hint="Obrigatório"
                  v-model="correspondencia.tipoDocumento"
                  :options="optionsTipoDocumento"
                  error-message="Obrigatório"
                  classe="form-input"
                  label="Tipo de Documento"
                  @input="$v.correspondencia.tipoDocumento.$touch()"
                  required
                />
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-md-3">
                <q-input label="Número"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.correspondencia.numeroDocumento.$error"
                  error-message="Obrigatório" type="text" v-model="correspondencia.numeroDocumento" @input="$v.correspondencia.numeroDocumento.$touch()" name="numero"/>
              </div>

            </div>
            <div class="row">
              <div class="col-md-2">
                <q-input class="form-input"
                  label="Codigo de Rastreio" autocomplete="on" type="text" v-model="correspondencia.codigoRastreio" name="text" >
                </q-input>
              </div>
              <div class="col-md-7">
                <form-select
                  :error="$v.correspondencia.setor.$error"
                  hint="Obrigatório"
                  v-model="correspondencia.setor"
                  :options="optionsSetor"
                  error-message="Obrigatório"
                  classe="form-input"
                  label="Origem"
                  @input="$v.correspondencia.setor.$touch()"
                  required
                />
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-md-3">
                <q-input class="form-input" label="Remetente" autocomplete="on" type="text" v-model="correspondencia.remetente" name="name"/>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <q-field class="form-input" label="É endereço cadastrado?" stack-label borderless>
                  <q-option-group inline
                    v-model="correspondencia.enderecoCadastrado"
                    :options="[
                      {
                        label: 'Sim',
                        value: '1'
                      },
                      {
                        label: 'Não',
                        value: '0'
                      }
                    ]"
                    color="primary"
                  />
                </q-field>
              </div>

              <div class="col-md-8" v-show="correspondencia.enderecoCadastrado === '1'">
                <form-select
                  label="Destino"
                  hint="Obrigatório"
                  :error="$v.correspondencia.destino.$error"
                  error-message="Obrigatório"
                  v-model="correspondencia.destino"
                  :options="optionsEndereco"
                  classe="form-input"
                  @input="procurarEnderecoCadastrado"
                  required
                />
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>

              <!-- <div class="col-md-7" v-show="correspondencia.enderecoCadastrado">
                <q-input class="form-input"
                  label="Destino"
                  hint="Obrigatório"
                  :error="$v.correspondencia.destino.$error"
                  error-message="Obrigatório" autocomplete="on" type="text" v-model="correspondencia.destino" name="destino" >
                </q-input>
              </div> -->

              <div class="col-md-8" v-show="correspondencia.enderecoCadastrado === '0'">
                <q-input class="form-input"
                  label="Destino"
                  hint="Obrigatório"
                  :error="$v.correspondencia.destino.$error"
                  error-message="Obrigatório" autocomplete="on" type="text" v-model="correspondencia.destino" name="destino" >
                  <!-- <q-autocomplete
                    @search="search"
                    :min-characters="3"
                    @selected="selected"
                  /> -->
                </q-input>
              </div>
            </div>

            <q-expansion-item label="Endereço" default-opened>
              <div class="panel-body">
                <div class="row">

                  <div class="col-md-3">
                    <q-input class="form-input"
                      label="Cep" autocomplete="off" type="text" v-model="correspondencia.cep" @input="procuraCep" v-mask="'99999-999'" placeholder="00000-000" name="cep"/>
                  </div>

                  <div class="col-md-7">
                    <q-input class="form-input"
                      label="Logradouro" autocomplete="off" type="text" v-model="correspondencia.logradouro" name="logradouro"/>
                  </div>
                  <div class="col-md-2">
                    <q-input class="form-input" label="Número" autocomplete="off" type="text" v-model="correspondencia.numero" name="numero"/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <q-input class="form-input" label="Complemento" autocomplete="off" type="text" v-model="correspondencia.complemento" name="complemento"/>
                  </div>

                  <div class="col-md-4">
                    <q-input class="form-input" label="Referência" autocomplete="off" type="text" v-model="correspondencia.referencia" name="referencia"/>
                  </div>
                  <div class="col-md-4">
                    <q-input class="form-input" label="Bairro" autocomplete="off" type="text" v-model="correspondencia.bairro" name="bairro"/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <q-input class="form-input" label="Cidade" autocomplete="off" type="text" v-model="correspondencia.cidade" name="cidade"/>
                  </div>
                  <div class="col-md-6">
                    <form-select
                      v-model="correspondencia.uf"
                      :options="optionsEstados"
                      classe="form-input"
                      label="Estado"
                      required
                    />
                  </div>
                </div>

              </div>
              <q-inner-loading :visible="cepLoading">
                <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
              </q-inner-loading>
            </q-expansion-item>
            <div class="row">
              <div class="col-md-4">
                <form-select
                  label="Tipo de Correspondência"
                  :error="$v.correspondencia.tipoCorrespondencia.$error"
                  error-message="Obrigatório"
                  hint="Obrigatório"
                  v-model="correspondencia.tipoCorrespondencia"
                  :options="optionsTipoCorrespondencia"
                  classe="form-input"
                  required
                  @input="somaTipoCorrespondencia"
                />
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-md-4">
                <form-select
                  label="Tipo de Cobrança"
                  v-model="correspondencia.tipoCobranca"
                  :options="optionsTipoCobranca"
                  classe="form-input"
                  required
                  @input="somaTipoCobranca"
                />
                <q-linear-progress indeterminate v-show="optionsLoading"/>
              </div>
              <div class="col-md-4">
                <q-input label="Valor Total"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.correspondencia.valorTotal.$error"
                  error-message="Obrigatório" autocomplete="off" type="tel" v-model.lazy="correspondencia.valorTotal" name="valor" prefix="R$" numeric-keyboard-toggle v-money="money" @input="$v.correspondencia.valorTotal.$touch()"/>
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

import ListaDeRegistros from './ListaCorrespondencias.vue'
import { required } from 'vuelidate/lib/validators'
import Correspondencia from './Correspondencia'
import correspondenciaService from './CorrespondenciaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import cepService from 'src/services/cep/CepService'
import optionsEstados from 'src/services/classes/EstadosBr'
import AwesomeMask from 'awesome-mask'
import VMoney from 'src/tools/money'
import enderecoService from 'src/pages/cadastro/endereco/EnderecoService'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import TipoCorrespondencia from 'src/pages/cadastro/tipoCorrespondencia/TipoCorrespondencia'
import Setor from 'src/pages/cadastro/setor/Setor'
import TipoCobranca from 'src/pages/cadastro/tipoCobranca/TipoCobranca'
import formSelect from 'src/components/form/select/QSelect'
import tools from 'src/tools'

export default {
  name: 'Cadastro-de-Correspondencias',
  components: {
    ListaDeRegistros,
    BodyTabs,
    formSelect
  },
  directives: {
    mask: AwesomeMask,
    money: VMoney
  },
  data () {
    return {
      correspondencia: new Correspondencia(),
      tipoDocumento: new TipoDocumento(),
      tipoCorrespondencia: new TipoCorrespondencia(),
      tipoCobranca: new TipoCobranca(),
      endereco: new Endereco(),
      setor: new Setor(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarCorrespondencia: false,
      possoExcluirCorrespondencia: false,
      optionsTipoDocumento: [],
      enderecoCadastrado: true,
      optionsEndereco: [],
      optionsSetor: [],
      optionsTipoCorrespondencia: [],
      optionsTipoCobranca: [],
      optionsLoading: false,
      optionsEstados: optionsEstados,
      cepLoading: false,
      valorTipoCorrespondencia: 0,
      valorTipoCobranca: 0,
      money: {
        decimal: '.',
        thousands: '',
        prefix: '',
        suffix: '',
        precision: 2,
        masked: true /* doesn't work with directive */
      },
      timer: ''
    }
  },
  validations: {
    correspondencia: {
      tipoDocumento: { required },
      numeroDocumento: { required },
      valorTotal: { required },
      dataCadastro: { required },
      destino: { required },
      setor: { required },
      tipoCorrespondencia: { required }
    }
  },
  methods: {
    // enderecoCadastradoSelecionado () {
    //   this.$v.correspondencia.destino.$touch()
    //   // get endereco
    //   console.log('pegar o endereco do back')
    // },
    preparaDocSemelhante () {
      this.$v.correspondencia.$reset()
      this.$router.push({ name: 'correspondencia' })
      this.possoAlterarCorrespondencia = false
      this.possoExcluirCorrespondencia = false

      const correspondencia = new Correspondencia(this.correspondencia)
      correspondencia.protocolo = ''
      correspondencia.correspondencia = ''
      correspondencia.destino = ''
      correspondencia.codigoRastreio = ''
      correspondencia.usuarioCriador = ''
      correspondencia.usuarioAlterador = ''
      this.correspondencia = new Correspondencia(correspondencia)
    },
    somaTipoCorrespondencia () {
      this.$v.correspondencia.tipoCorrespondencia.$touch()
      this.valorTipoCorrespondencia = Number(this.optionsTipoCorrespondencia.filter(tipoCorrespondencia => tipoCorrespondencia.value === this.correspondencia.tipoCorrespondencia)[0].valor)
      this.somaValores()
    },
    somaTipoCobranca () {
      this.valorTipoCobranca = Number(this.optionsTipoCobranca.filter(tipoCobranca => tipoCobranca.value === this.correspondencia.tipoCobranca)[0].valor)
      this.somaValores()
    },
    somaValores () {
      this.correspondencia.valorTotal = (this.valorTipoCorrespondencia + this.valorTipoCobranca).toFixed(2)
    },
    toogleEnderecoCadastrado () {
      this.correspondencia.enderecoCadastrado = !this.correspondencia.enderecoCadastrado
      if (this.correspondencia.enderecoCadastrado === false) {
        this.correspondencia.logradouro = ''
        this.correspondencia.numero = ''
        this.correspondencia.complemento = ''
        this.correspondencia.bairro = ''
        this.correspondencia.cidade = ''
        this.correspondencia.uf = ''
        this.correspondencia.cep = ''
        this.correspondencia.referencia = ''
      } else {
        this.correspondencia.destino = ''
      }
    },
    carregaEndereco (endereco) {
      this.correspondencia.logradouro = endereco.logradouro
      this.correspondencia.numero = endereco.numero
      this.correspondencia.complemento = endereco.complemento
      this.correspondencia.bairro = endereco.bairro
      this.correspondencia.cidade = endereco.cidade
      this.correspondencia.uf = endereco.uf
      this.correspondencia.cep = endereco.cep
      this.correspondencia.referencia = endereco.referencia
    },
    procuraCep () {
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.correspondencia.cep.length === 9) {
          this.cepLoading = true
          this.correspondencia.logradouro = ''
          this.correspondencia.bairro = ''
          this.correspondencia.cidade = ''
          this.correspondencia.uf = ''
          cepService
            .procura(this.correspondencia.cep, this.cepLoading)
            .then(result => {
              const cep = result
              this.correspondencia.logradouro = cep.logradouro
              this.correspondencia.bairro = cep.bairro
              this.correspondencia.cidade = cep.localidade
              this.correspondencia.uf = cep.uf
              this.cepLoading = false
            })
            .catch(error => {
              this.cepLoading = false
              console.log(error)
              tools.Notify.warning('Cep não encontrado.')
            })
        }
      }, 300)
    },
    parseEnderecos () {
      return this.optionsEndereco.map(correspondencia => {
        // console.log(correspondencia)

        return {
          label: correspondencia.label,
          value: correspondencia.value
        }
      })
    },
    procurarEnderecoCadastrado () {
      this.$v.correspondencia.destino.$touch()
      // search do autocomplete
      setTimeout(() => {
        console.log('selecionei quartel')
        enderecoService
          .buscaEnderecoPorCodigo(this.correspondencia.destino)
          .then(result => {
            console.log('peguei o correspondencia com sucesso')
            this.carregaEndereco(result.data[0])

            // this.optionsEndereco = this.endereco.setOptions(result.data)
            // done(this.optionsEndereco)
          })
      }, 300)
    },
    procuraEndereco (busca) {
      this.$v.correspondencia.origem.$touch()
      console.log(busca)
      console.log('procurando no select')
    },
    reset () {
      this.$v.correspondencia.$reset()
      this.correspondencia = new Correspondencia()
      this.$router.push({ name: 'correspondencia' })
      this.possoAlterarCorrespondencia = false
      this.possoExcluirCorrespondencia = false
    },
    carrega (id) {
      console.log('vou carregar o correspondencia')
      tools.Loadings.processando()

      correspondenciaService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o correspondencia com sucesso')
          this.correspondencia = Object.assign({}, this.correspondencia, result.data)
          this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
            registro: this.correspondencia,
            id: 'correspondencia'
          })
          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.correspondencia.$touch()
      // if (this.$v.tabelacorrespondenciaAcessoEmpresa.$invalid) return tools.Dialogs.formInvalido()
      // revisar mais tarde,, dispensa natal

      tools.Loadings.processando()
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.correspondencia.correspondencia && this.possoAlterarCorrespondencia) {
          console.log('estou alterando o form')
          correspondenciaService.altera(this.correspondencia)
            .then(result => {
              tools.Loadings.hide()
              console.log('correspondencia alterado com sucesso')
              const tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.correspondencia.tipoDocumento)
              const setorDescricao = this.optionsSetor.filter(tipo => tipo.value === this.correspondencia.setor)
              this.correspondencia.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.correspondencia.setorDescricao = setorDescricao[0].label
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.correspondencia,
                id: 'correspondencia'
              })
              tools.Notify.positive('Correspondência alterada com sucesso.')
            })
        } else if (!this.correspondencia.correspondencia && this.possoGravarCorrespondencia) {
          correspondenciaService.grava(this.correspondencia)
            .then(result => {
              console.log('correspondencia criado com sucesso')
              this.correspondencia.correspondencia = result.data.correspondencia.correspondencia
              this.correspondencia.usuarioCriador = result.data.correspondencia.usuarioCriador
              this.$router.push('/correspondencias/correspondencia/' + result.data.correspondencia.correspondencia)
              tools.Notify.positive('Correspondência criada com sucesso.')

              const tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.correspondencia.tipoDocumento)
              this.correspondencia.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label

              const setorDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.correspondencia.setor)
              this.correspondencia.setorDescricao = setorDescricao[0].label
              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.correspondencia)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirCorrespondencia) {
        this.$q.dialog({
          title: 'Tem certeza?',
          message: 'Ao confirmar esta operação, não poderá desfazer.',
          ok: 'Sim, excluir',
          cancel: 'Cancelar'
        }).onOk(() => {
          tools.Loadings.processando()

          correspondenciaService.apaga(this.correspondencia.correspondencia)
            .then(result => {
              tools.Loadings.hide()
              console.log('correspondencia removido com sucesso')
              tools.Notify.negative('Correspondência removida com sucesso.')
              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.correspondencia.correspondencia,
                id: 'correspondencia'
              })
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarCorrespondencia = permissoes.alterar('correspondencia', this.correspondencia.usuarioCriador)
      this.possoExcluirCorrespondencia = permissoes.excluir('correspondencia', this.correspondencia.usuarioCriador)
    }
  },
  props: {
    id: {}
  },
  watch: {
    id: function (id) {
      if (id) this.carrega(id)
    }
  },
  computed: {
    possoGravarCorrespondencia: () => permissoes.gravar('correspondencia')
  },
  mounted () {
    this.optionsLoading = true
    correspondenciaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsEndereco = this.endereco.setOptions(result.data.endereco)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
        this.optionsTipoCorrespondencia = this.tipoCorrespondencia.setOptions(result.data.tipoCorrespondencia)
        this.optionsTipoCobranca = this.tipoCobranca.setOptions(result.data.tipoCobranca)
      })
  }
}
</script>
