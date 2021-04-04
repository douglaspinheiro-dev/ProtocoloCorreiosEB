<template>
  <div>
    <bodyTabs titulo="Cadastro de Endereços">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarEndereco">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!endereco.endereco && possoGravarEndereco" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="endereco.endereco && possoAlterarEndereco" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirEndereco">Excluir</q-btn>
              </div>
            </div>

            <q-expansion-item label="Dados Gerais" default-opened>
              <div class="row">
                <div class="col-md-6">
                  <q-input
                    label="Descrição"
                    class="form-input"
                    hint="Obrigatório"
                    :error="$v.endereco.descricao.$error"
                    :error-message="errorDescricao"
                    autocomplete="off" type="text" v-model="endereco.descricao" @input="$v.endereco.descricao.$touch()" name="descricao"/>
                </div>
                <div class="col-md-3">
                  <q-input
                    label="Código"
                    class="form-input"
                    hint="Obrigatório"
                    :error="$v.endereco.codigo.$error"
                    error-message="Obrigatório" autocomplete="off" type="text" v-model="endereco.codigo" @input="$v.endereco.codigo.$touch()" name="codigo"/>
                </div>
                <div class="col-md-3">
                  <q-field class="form-input" label="Status" stack-label borderless>
                    <q-option-group inline
                      v-model="endereco.status"
                      :options="[
                        {
                          label: 'Ativo',
                          value: 1
                        },
                        {
                          label: 'Inativo',
                          value: 0
                        }
                      ]"
                      color="primary"
                    />
                  </q-field>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <q-field class="form-input" label="É rota para Malote?" stack-label borderless>
                    <q-option-group inline
                      v-model="endereco.malote"
                      :options="[
                        {
                          label: 'Sim',
                          value: 1
                        },
                        {
                          label: 'Não',
                          value: 0
                        }
                      ]"
                      color="primary"
                    />
                  </q-field>
                </div>
                <div class="col-md-3" v-show="this.endereco.malote">
                  <form-select
                    classe="form-input"
                    hint="Obrigatório"
                    :error="$v.endereco.rota.$error"
                    error-message="Obrigatório"
                    label="Qual Rota?"
                    v-model="endereco.rota"
                    :options="optionsRota"
                    required
                  />
                  <q-linear-progress indeterminate v-show="optionsLoading"/>
                </div>
              </div>
            </q-expansion-item>
            <q-expansion-item label="Endereço" default-opened>
              <div class="panel-body">
                <div class="row">

                  <div class="col-md-3">
                      <q-input class="form-input"
                        label="Cep" autocomplete="off" type="text" v-model="endereco.cep" @input="procuraCep" v-mask="'99999-999'" placeholder="00000-000" name="cep"/>
                  </div>

                  <div class="col-md-7">
                      <q-input class="form-input"
                      label="Logradouro" autocomplete="off" type="text" v-model="endereco.logradouro" name="logradouro"/>
                  </div>
                  <div class="col-md-2">
                      <q-input class="form-input" label="Número" autocomplete="off" type="text" v-model="endereco.numero" name="numero"/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <q-input class="form-input" label="Complemento" autocomplete="off" type="text" v-model="endereco.complemento" name="complemento"/>
                  </div>

                  <div class="col-md-4">
                    <q-input class="form-input" label="Referência" autocomplete="off" type="text" v-model="endereco.referencia" name="referencia"/>
                  </div>
                  <div class="col-md-4">
                    <q-input class="form-input" label="Bairro" autocomplete="off" type="text" v-model="endereco.bairro" name="bairro"/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <q-input class="form-input" label="Cidade" autocomplete="off" type="text" v-model="endereco.cidade" name="cidade"/>
                  </div>
                  <div class="col-md-6">
                    <form-select
                      classe="form-input"
                      label="Estado"
                      hint="Obrigatório"
                      v-model="endereco.uf"
                      :options="optionsEstados"
                      required
                    />
                  </div>
                </div>

              </div>
              <q-inner-loading :visible="cepLoading">
                <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
              </q-inner-loading>
            </q-expansion-item>
          </form>
        </q-tab-panel>
      </template>
    </bodyTabs>
    <lista-de-registros />
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import ListaDeRegistros from './ListaEnderecos.vue'
import { required, requiredIf } from 'vuelidate/lib/validators'
import Endereco from './Endereco'
import enderecoService from './EnderecoService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import cepService from 'src/services/cep/CepService'
import optionsEstados from 'src/services/classes/EstadosBr'
import AwesomeMask from 'awesome-mask'
import Rota from 'src/pages/cadastro/rota/Rota'
import formSelect from 'src/components/form/select/QSelect'
import tools from 'src/tools'

export default {
  name: 'Cadastro-de-Enderecos',
  components: {
    BodyTabs,
    ListaDeRegistros,
    formSelect
  },
  directives: {
    mask: AwesomeMask
  },
  data () {
    return {
      endereco: new Endereco(),
      rota: new Rota(),
      errorDescricao: 'Preencha a descrição',
      optionsEstados: optionsEstados,
      cepLoading: false,
      possoAlterarEndereco: false,
      possoExcluirEndereco: false,
      optionsRota: [],
      optionsLoading: false,
      timer: ''
    }
  },
  validations: {
    endereco: {
      malote: { required },
      codigo: { required },
      descricao: {
        required,
        isUnique (value) {
          const descricao = value
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
          const retorno = confereRegistro('enderecos', 'descricao', opcao, id, 'endereco', descricao)
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
      },
      rota: {
        required: requiredIf(function (nestedModel) {
          return nestedModel.malote
        })
      }
    }
  },
  methods: {
    procuraCep () {
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.endereco.cep.length === 9) {
          this.cepLoading = true
          this.endereco.logradouro = ''
          this.endereco.bairro = ''
          this.endereco.cidade = ''
          this.endereco.uf = ''
          cepService
            .procura(this.endereco.cep, this.cepLoading)
            .then(result => {
              const cep = result
              this.endereco.logradouro = cep.logradouro
              this.endereco.bairro = cep.bairro
              this.endereco.cidade = cep.localidade
              this.endereco.uf = cep.uf
              this.cepLoading = false
            })
            .catch(error => {
              this.cepLoading = false
              console.log(error)
              tools.Notify.warning('Cep não encontrado')
            })
        }
      }, 300)
    },
    reset () {
      this.$v.endereco.$reset()
      this.endereco = new Endereco()
      this.botaoSalvarAlterar = 'Gravar'
      this.$router.push({ name: 'endereco' })
      this.possoAlterarEndereco = false
      this.possoExcluirEndereco = false
    },
    carrega (id) {
      console.log('vou carregar o endereco')
      tools.Loadings.processando()

      enderecoService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o endereco com sucesso')
          this.endereco = Object.assign({}, this.endereco, result.data)
          this.botaoSalvarAlterar = 'Alterar'
          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.endereco.$touch()
      if (this.$v.endereco.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.endereco.endereco && this.possoAlterarEndereco) {
          console.log('estou alterando o form')
          enderecoService.altera(this.endereco)
            .then(result => {
              tools.Loadings.hide()
              console.log('endereco alterado com sucesso')
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.endereco,
                id: 'endereco'
              })
              tools.Notify.positive('Endereco alterado com sucesso')
            })
        } else if (!this.endereco.endereco && this.possoGravarEndereco) {
          enderecoService.grava(this.endereco)
            .then(result => {
              console.log('endereco criado com sucesso')
              this.endereco.endereco = result.data.endereco.endereco
              this.endereco.usuarioCriador = result.data.endereco.usuarioCriador
              this.$router.push('/enderecos/endereco/' + result.data.endereco.endereco)
              tools.Notify.positive('Endereco criado com sucesso')

              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.endereco)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
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
        }).onOk(() => {
          tools.Loadings.processando()

          enderecoService.apaga(this.endereco.endereco)
            .then(result => {
              tools.Loadings.hide()
              console.log('endereco removido com sucesso')
              tools.Notify.negative('Endereco removido com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.endereco.endereco,
                id: 'endereco'
              })
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
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
      if (id) this.carrega(id)
    }
  },
  computed: {
    possoGravarEndereco: () => permissoes.gravar('endereco')
  },
  mounted () {
    this.optionsLoading = true
    enderecoService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsRota = this.rota.setOptions(result.data.rotas)
      })
  }
}
</script>
