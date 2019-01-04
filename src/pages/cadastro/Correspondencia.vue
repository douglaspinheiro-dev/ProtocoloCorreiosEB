<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Correspondências</q-toolbar-title>
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarCorrespondencia">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!correspondencia.correspondencia && possoGravarCorrespondencia" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="correspondencia.correspondencia && possoAlterarCorrespondencia" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirCorrespondencia">Excluir</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <q-field label="Nº" orientation="vertical" class="form-input">
                  {{correspondencia.anoCadastro+'-'+correspondencia.protocolo}}
                </q-field>
              </div>
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Data do cadastro"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.correspondencia.dataCadastro.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="off" type="date" v-model="correspondencia.dataCadastro" name="data" />
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Tipo de Documento" orientation="vertical"
                  :error="$v.correspondencia.tipoDocumento.$error"
                  error-label="Obrigatório"
                  helper="Obrigatório"
                >
                  <q-select
                    v-model="correspondencia.tipoDocumento"
                    :options="optionsTipoDocumento"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o Tipo de Documento"
                    name="select"
                    @input="$v.correspondencia.tipoDocumento.$touch()"
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
                  :error="$v.correspondencia.numero.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="off" type="text" v-model="correspondencia.numero" @input="$v.correspondencia.numero.$touch()" name="numero"/>
                </q-field>
              </div>

            </div>
            <div class="row">
              <div class="col-md-12">
                <q-field class="form-input" label="Origem" orientation="vertical"
                  :error="$v.correspondencia.setor.$error"
                  error-label="Obrigatório"
                  helper="Obrigatório"
                >
                  <q-select
                    v-model="correspondencia.setor"
                    :options="optionsSetor"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o origem"
                    name="select"
                    @input="$v.correspondencia.setor.$touch()"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <q-field class="form-input" label="É endereço cadastrado?" orientation="vertical">
                  <q-btn-group  class="fit">
                    <radio-button :status="correspondencia.enderecoCadastrado"
                    @toggleRadioButton="toogleEnderecoCadastrado"
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
                  :error="$v.correspondencia.origem.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="correspondencia.origem"
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

              <div class="col-md-8" v-show="correspondencia.enderecoCadastrado">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.correspondencia.destino.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="on" type="text" v-model="correspondencia.destino" name="destino" >
                    <!-- <q-autocomplete
                      :static-data="{field: 'value', list: optionsEndereco}"
                      :min-characters="3"
                      @selected="procurarEnderecoCadastrado"
                    /> -->
                    <q-autocomplete
                      :min-characters="3"
                      @selected="carregaEndereco"
                      @search="procurarEnderecoCadastrado"
                    />
                  </q-input>
                </q-field>
              </div>

              <div class="col-md-8" v-show="!correspondencia.enderecoCadastrado">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.correspondencia.destino.$error"
                  error-label="Obrigatório"
                >
                  <q-input autocomplete="on" type="text" v-model="correspondencia.destino" name="destino" >
                    <!-- <q-autocomplete
                      @search="search"
                      :min-characters="3"
                      @selected="selected"
                    /> -->
                  </q-input>
                </q-field>
              </div>
            </div>

            <q-collapsible label="Endereço" opened>
              <div class="panel-body">
                <div class="row">

                  <div class="col-md-3">
                    <q-field class="form-input"
                      label="Cep"
                      orientation="vertical"
                    >
                      <q-input autocomplete="off" type="text" v-model="correspondencia.cep" @input="procuraCep" v-mask="'99999-999'" placeholder="00000-000" name="cep"/>
                    </q-field>
                  </div>

                  <div class="col-md-7">
                    <q-field class="form-input"
                      label="Logradouro"
                      orientation="vertical"
                    >
                      <q-input autocomplete="off" type="text" v-model="correspondencia.logradouro" name="logradouro"/>
                    </q-field>
                  </div>
                  <div class="col-md-2">
                    <q-field class="form-input" label="Número" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="correspondencia.numero" name="numero"/>
                    </q-field>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <q-field class="form-input" label="Complemento" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="correspondencia.complemento" name="complemento"/>
                    </q-field>
                  </div>

                  <div class="col-md-4">
                    <q-field class="form-input" label="Referência" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="correspondencia.referencia" name="referencia"/>
                    </q-field>
                  </div>
                  <div class="col-md-4">
                    <q-field class="form-input" label="Bairro" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="correspondencia.bairro" name="bairro"/>
                    </q-field>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <q-field class="form-input" label="Cidade" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="correspondencia.cidade" name="cidade"/>
                    </q-field>
                  </div>
                  <div class="col-md-6">
                    <q-field class="form-input" label="Estado" orientation="vertical">
                      <q-select
                        v-model="correspondencia.uf"
                        :options="optionsEstados"
                        filter
                        autofocus-filter
                        filter-placeholder="Digite o estado"
                        name="uf"
                      />
                    </q-field>
                  </div>
                </div>

              </div>
              <q-inner-loading :visible="cepLoading">
                <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
              </q-inner-loading>
            </q-collapsible>
          </form>

          <botao-mobile
            :id="correspondencia.correspondencia"
            :possoGravar="possoGravarCorrespondencia"
            :possoAlterar="possoAlterarCorrespondencia"
            :possoExcluir="possoExcluirCorrespondencia"
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
import ListaDeRegistros from 'src/components/menuRight/ListaCorrespondencias.vue'
import { required } from 'vuelidate/lib/validators'
import Correspondencia from 'src/services/correspondencia/Correspondencia'
import correspondenciaService from 'src/services/correspondencia/CorrespondenciaService'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
// import { filter } from 'quasar'
import cepService from 'src/services/cep/CepService'
import optionsEstados from 'src/services/classes/EstadosBr'
import AwesomeMask from 'awesome-mask'
import enderecoService from 'src/services/endereco/EnderecoService'

var timer

export default {
  name: 'Cadastro-de-Correspondencias',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    RadioButton,
    botaoMobile
  },
  directives: {
    'mask': AwesomeMask
  },
  data () {
    return {
      correspondencia: new Correspondencia(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarCorrespondencia: false,
      possoExcluirCorrespondencia: false,
      optionsTipoDocumento: [],
      enderecoCadastrado: true,
      optionsEndereco: [],
      optionsSetor: [],
      optionsLoading: false,
      optionsEstados: optionsEstados,
      cepLoading: false
    }
  },
  validations: {
    correspondencia: {
      tipoDocumento: {required},
      numero: {required},
      dataCadastro: {required},
      destino: {required},
      setor: {required}
    }
  },
  methods: {
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
    carregaEndereco () {
      console.log('carregando endereco quartel')
      let endereco = this.optionsEndereco.filter(endereco => endereco.value === this.correspondencia.destino)[0]
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
      clearTimeout(timer)
      timer = setTimeout(() => {
        if (this.correspondencia.cep.length === 9) {
          this.cepLoading = true
          this.correspondencia.logradouro = ''
          this.correspondencia.bairro = ''
          this.correspondencia.cidade = ''
          this.correspondencia.uf = ''
          cepService
            .procura(this.correspondencia.cep, this.cepLoading)
            .then(result => {
              let cep = result
              this.correspondencia.logradouro = cep.logradouro
              this.correspondencia.bairro = cep.bairro
              this.correspondencia.cidade = cep.localidade
              this.correspondencia.uf = cep.uf
              this.cepLoading = false
            })
            .catch(error => {
              this.cepLoading = false
              console.log(error)
              this.$q.notify({
                type: 'warning',
                message: 'Cep não encontrado',
                timeout: 2000
              })
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
    procurarEnderecoCadastrado (terms, done) {
      // search do autocomplete
      setTimeout(() => {
        console.log('selecionei quartel')
        enderecoService
          .buscaEnderecoPorCodigo(this.correspondencia.destino)
          .then(result => {
            console.log('peguei o correspondencia com sucesso')
            this.setOptionsEndereco(result.data)
            done(this.optionsEndereco)
          })
      }, 300)
    },
    procuraEndereco (busca) {
      this.$v.correspondencia.origem.$touch()
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
            value: endereco.codigoReduzido,
            logradouro: endereco.logradouro,
            numero: endereco.numero,
            complemento: endereco.complemento,
            bairro: endereco.bairro,
            cidade: endereco.cidade,
            uf: endereco.uf,
            cep: endereco.cep,
            referencia: endereco.referencia

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
      this.correspondencia.status = !this.correspondencia.status
    },
    reset () {
      this.$v.correspondencia.$reset()
      this.correspondencia = new Correspondencia()
      this.$router.push({name: 'correspondencia'})
      this.possoAlterarCorrespondencia = false
      this.possoExcluirCorrespondencia = false
    },
    carrega (id) {
      console.log('vou carregar o correspondencia')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      correspondenciaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o correspondencia com sucesso')
          this.correspondencia = Object.assign({}, this.correspondencia, result.data)
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
        this.$v.correspondencia.$touch()
        if (this.$v.correspondencia.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.correspondencia.correspondencia && this.possoAlterarCorrespondencia) {
          console.log('estou alterando o form')
          correspondenciaService.altera(this.correspondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('correspondencia alterado com sucesso')
              let tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.correspondencia.tipoDocumento)
              this.correspondencia.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$root.$emit('alteraUnicoRegistro', this.correspondencia)
              this.$q.notify({
                type: 'positive',
                message: 'Protocolo de Entrada alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.correspondencia.correspondencia && this.possoGravarCorrespondencia) {
          correspondenciaService.grava(this.correspondencia)
            .then(result => {
              console.log('correspondencia criado com sucesso')
              this.correspondencia.correspondencia = result.data.correspondencia.correspondencia
              this.correspondencia.usuarioCriador = result.data.correspondencia.usuarioCriador
              this.$router.push('/correspondencias/correspondencia/' + result.data.correspondencia.correspondencia)
              this.$q.notify({
                type: 'positive',
                message: 'Protocolo de Entrada criado com sucesso.',
                timeout: 5000
              })
              let tipoDocumentoDescricao = this.optionsTipoDocumento.filter(tipo => tipo.value === this.correspondencia.tipoDocumento)
              this.correspondencia.tipoDocumentoDescricao = tipoDocumentoDescricao[0].label
              this.$root.$emit('adicionaRegistroNaLista', this.correspondencia)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
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
        }).then(() => {
          this.$q.loading.show({
            message: 'Processando sua requisição',
            messageColor: 'white',
            spinnerSize: 250, // in pixels
            spinnerColor: 'white'
          })

          correspondenciaService.apaga(this.correspondencia.correspondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('correspondencia removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Protocolo de Entrada removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.correspondencia.correspondencia)
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
      this.possoAlterarCorrespondencia = permissoes.alterar('correspondencia', this.correspondencia.usuarioCriador)
      this.possoExcluirCorrespondencia = permissoes.excluir('correspondencia', this.correspondencia.usuarioCriador)
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
    possoGravarCorrespondencia: () => permissoes.gravar('correspondencia')
  },
  mounted () {
    this.optionsLoading = true
    correspondenciaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsTipoDocumento(result.data.tipoDocumento)
        this.setOptionsEndereco(result.data.endereco)
        this.setOptionsSetor(result.data.setor)
      })
  }
}
</script>
