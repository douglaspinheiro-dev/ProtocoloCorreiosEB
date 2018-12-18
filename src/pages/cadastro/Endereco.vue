<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Endereços</q-toolbar-title>
        <botao-menu-right/>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted>
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="folder shared" label="Cadastro"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarEndereco">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!endereco.endereco && possoGravarEndereco" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="endereco.endereco && possoAlterarEndereco" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirEndereco">Excluir</q-btn>
              </div>
            </div>

            <q-collapsible label="Dados Gerais" opened>
              <div class="row">

                <div class="col-md-6">
                  <q-field
                    label="Descrição"
                    orientation="vertical"
                    class="form-input"
                    helper="Obrigatório"
                    :error="$v.endereco.descricao.$error"
                    :error-label="errorDescricao"
                  >
                    <q-input autocomplete="off" type="text" v-model="endereco.descricao" @input="$v.endereco.descricao.$touch()" name="descricao"/>
                  </q-field>
                </div>
                <div class="col-md-3">
                  <q-field
                    label="Código"
                    orientation="vertical"
                    class="form-input"
                    helper="Obrigatório"
                    :error="$v.endereco.codigo.$error"
                    error-label="Obrigatório"
                  >
                    <q-input autocomplete="off" type="text" v-model="endereco.codigo" @input="$v.endereco.codigo.$touch()" name="codigo"/>
                  </q-field>
                </div>
                <div class="col-md-3">
                  <q-field class="form-input" label="Status" orientation="vertical">
                    <q-btn-group  class="fit">
                      <radio-button :status="endereco.status" @toggleRadioButton="toggleStatus"/>
                    </q-btn-group>
                  </q-field>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <q-field class="form-input" label="É rota para Malote?" orientation="vertical">
                    <q-btn-group  class="fit">
                      <radio-button :status="endereco.malote" @toggleRadioButton="toggleMalote" :label="['Sim', 'Não']"/>
                    </q-btn-group>
                  </q-field>
                </div>
              </div>
            </q-collapsible>
            <q-collapsible label="Endereço" opened>
              <div class="panel-body">
                <div class="row">

                  <div class="col-md-3">
                    <q-field class="form-input"
                      label="Cep"
                      orientation="vertical"
                    >
                      <q-input autocomplete="off" type="text" v-model="endereco.cep" @input="procuraCep" v-mask="'99999-999'" placeholder="00000-000" name="cep"/>
                    </q-field>
                  </div>

                  <div class="col-md-7">
                    <q-field class="form-input"
                      label="Logradouro"
                      orientation="vertical"
                    >
                      <q-input autocomplete="off" type="text" v-model="endereco.logradouro" name="logradouro"/>
                    </q-field>
                  </div>
                  <div class="col-md-2">
                    <q-field class="form-input" label="Número" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="endereco.numero" name="numero"/>
                    </q-field>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <q-field class="form-input" label="Complemento" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="endereco.complemento" name="complemento"/>
                    </q-field>
                  </div>

                  <div class="col-md-4">
                    <q-field class="form-input" label="Referência" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="endereco.referencia" name="referencia"/>
                    </q-field>
                  </div>
                  <div class="col-md-4">
                    <q-field class="form-input" label="Bairro" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="endereco.bairro" name="bairro"/>
                    </q-field>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <q-field class="form-input" label="Cidade" orientation="vertical">
                      <q-input autocomplete="off" type="text" v-model="endereco.cidade" name="cidade"/>
                    </q-field>
                  </div>
                  <div class="col-md-6">
                    <q-field class="form-input" label="Estado" orientation="vertical">
                      <q-select
                        v-model="endereco.uf"
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
            :id="endereco.endereco"
            :possoGravar="possoGravarEndereco"
            :possoAlterar="possoAlterarEndereco"
            :possoExcluir="possoExcluirEndereco"
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
import ListaDeRegistros from 'src/components/menuRight/ListaEnderecos.vue'
import { required } from 'vuelidate/lib/validators'
import Endereco from 'src/services/endereco/Endereco'
import enderecoService from 'src/services/endereco/EnderecoService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from '../../tools/Notify'
import cepService from 'src/services/cep/CepService'
import optionsEstados from 'src/services/classes/EstadosBr'
import AwesomeMask from 'awesome-mask'
import botaoMobile from 'src/components/QFab/QFab'
var timer

export default {
  name: 'Cadastro-de-Enderecos',
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
      endereco: new Endereco(),
      errorDescricao: 'Preencha a descrição',
      optionsEstados: optionsEstados,
      cepLoading: false,
      possoAlterarEndereco: false,
      possoExcluirEndereco: false
    }
  },
  validations: {
    endereco: {
      codigo: {required},
      cep: {required},
      descricao: {
        required,
        isUnique (value) {
          let descricao = value
          // se for vazio, passo a bola pro validador required
          if (descricao === '') {
            return true
          }
          let opcao = 'gravar'
          let id = ''
          if (this.endereco.endereco) {
            opcao = 'alterar'
            id = this.endereco.endereco
          }
          let retorno = confereRegistro('enderecos', 'descricao', opcao, id, 'endereco', descricao)
            .then(result => {
              if (result.status === 200) {
                if (result.data.resposta === true) {
                  return true
                } else {
                  this.errorDescricao = 'Esta descrição ja está em, escolha outra'
                  return false
                }
              }
            })
          return retorno
        }
      }
    }
  },
  methods: {
    procuraCep () {
      clearTimeout(timer)
      timer = setTimeout(() => {
        if (this.endereco.cep.length === 9) {
          this.cepLoading = true
          this.endereco.logradouro = ''
          this.endereco.bairro = ''
          this.endereco.cidade = ''
          this.endereco.uf = ''
          cepService
            .procura(this.endereco.cep, this.cepLoading)
            .then(result => {
              let cep = result
              this.endereco.logradouro = cep.logradouro
              this.endereco.bairro = cep.bairro
              this.endereco.cidade = cep.localidade
              this.endereco.uf = cep.uf
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
    toggleStatus () {
      this.endereco.status = !this.endereco.status
    },
    toggleMalote () {
      this.endereco.malote = !this.endereco.malote
    },
    reset () {
      this.$v.endereco.$reset()
      this.endereco = new Endereco()
      this.botaoSalvarAlterar = 'Gravar'
      this.$router.push({name: 'endereco'})
      this.possoAlterarEndereco = false
      this.possoExcluirEndereco = false
    },
    carrega (id) {
      console.log('vou carregar o endereco')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      enderecoService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o endereco com sucesso')
          this.endereco = Object.assign({}, this.endereco, result.data)
          this.botaoSalvarAlterar = 'Alterar'
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
        this.$v.endereco.$touch()
        if (this.$v.endereco.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.endereco.endereco && this.possoAlterarEndereco) {
          console.log('estou alterando o form')
          enderecoService.altera(this.endereco)
            .then(result => {
              this.$q.loading.hide()
              console.log('endereco alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.endereco)
              this.$q.notify({
                type: 'positive',
                message: 'Endereco alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.endereco.endereco && this.possoGravarEndereco) {
          enderecoService.grava(this.endereco)
            .then(result => {
              console.log('endereco criado com sucesso')
              this.endereco.endereco = result.data.endereco.endereco
              this.endereco.usuarioCriador = result.data.endereco.usuarioCriador
              this.$router.push('/enderecos/endereco/' + result.data.endereco.endereco)
              this.$q.notify({
                type: 'positive',
                message: 'Endereco criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.endereco)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirEndereco) {
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

          enderecoService.apaga(this.endereco.endereco)
            .then(result => {
              this.$q.loading.hide()
              console.log('endereco removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Endereco removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.endereco.endereco)
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
      this.possoAlterarEndereco = permissoes.alterar('endereco', this.endereco.usuarioCriador)
      this.possoExcluirEndereco = permissoes.excluir('endereco', this.endereco.usuarioCriador)
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
    possoGravarEndereco: () => permissoes.gravar('endereco')
  }
}
</script>
