<template>
  <div>
    <bodyTabs titulo="Cadastro de Tipos de Cobrança">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarTipoCobranca">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!tipoCobranca.tipoCobranca && possoGravarTipoCobranca" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="tipoCobranca.tipoCobranca && possoAlterarTipoCobranca" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirTipoCobranca">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <q-input
                  label="Descrição"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.tipoCobranca.descricao.$error"
                  :error-message="errorDescricao"
                  autocomplete="off" type="text" v-model="tipoCobranca.descricao" @input="$v.tipoCobranca.descricao.$touch()" name="descricao"/>
              </div>
              <div class="col-md-4">
                <q-input
                  label="Valor"
                  class="form-input"
                  autocomplete="off" type="tel" v-model.lazy="tipoCobranca.valor" name="valor" prefix="R$" numeric-keyboard-toggle v-money="money"/>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Status" stack-label borderless>
                  <q-option-group inline
                    v-model="tipoCobranca.status"
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
          </form>
        </q-tab-panel>
      </template>
    </bodyTabs>
    <lista-de-registros />
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'
import ListaDeRegistros from './ListaTipoCobrancas.vue'
import { required } from 'vuelidate/lib/validators'
import TipoCobranca from './TipoCobranca'
import tipoCobrancaService from './TipoCobrancaService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import VMoney from 'src/tools/money'

var timer

export default {
  name: 'Cadastro-de-TipoCobrancas',
  components: {
    ListaDeRegistros,
    BodyTabs
  },
  data () {
    return {
      tipoCobranca: new TipoCobranca(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarTipoCobranca: false,
      possoExcluirTipoCobranca: false,
      money: {
        decimal: '.',
        thousands: '',
        prefix: '',
        suffix: '',
        precision: 2,
        masked: true /* doesn't work with directive */
      }
    }
  },
  directives: {
    // 'mask': AwesomeMask
    money: VMoney
  },
  validations: {
    tipoCobranca: {
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
          if (this.tipoCobranca.tipoCobranca) {
            opcao = 'alterar'
            id = this.tipoCobranca.tipoCobranca
          }
          let retorno = confereRegistro('categoriasCobrancas', 'descricao', opcao, id, 'categoriaCobranca', descricao)
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
    toggleRadioButton () {
      this.tipoCobranca.status = !this.tipoCobranca.status
    },
    reset () {
      this.$v.tipoCobranca.$reset()
      this.tipoCobranca = new TipoCobranca()
      this.$router.push({name: 'tipoCobranca'})
      this.possoAlterarTipoCobranca = false
      this.possoExcluirTipoCobranca = false
    },
    carrega (id) {
      console.log('vou carregar o tipoCobranca')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      tipoCobrancaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o tipoCobranca com sucesso')
          this.tipoCobranca = Object.assign({}, this.tipoCobranca, result.data)
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
        this.$v.tipoCobranca.$touch()
        if (this.$v.tipoCobranca.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
          return
        }

        if (this.tipoCobranca.tipoCobranca && this.possoAlterarTipoCobranca) {
          console.log('estou alterando o form')
          tipoCobrancaService.altera(this.tipoCobranca)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoCobranca alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.tipoCobranca)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Cobrança alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.tipoCobranca.tipoCobranca && this.possoGravarTipoCobranca) {
          tipoCobrancaService.grava(this.tipoCobranca)
            .then(result => {
              console.log('tipoCobranca criado com sucesso')
              this.tipoCobranca.tipoCobranca = result.data.tipoCobranca.tipoCobranca
              this.tipoCobranca.usuarioCriador = result.data.tipoCobranca.usuarioCriador
              this.$router.push('/tipoCobrancas/tipoCobranca/' + result.data.tipoCobranca.tipoCobranca)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Cobrança criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.tipoCobranca)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirTipoCobranca) {
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

          tipoCobrancaService.apaga(this.tipoCobranca.tipoCobranca)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoCobranca removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Tipo de Cobrança removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.tipoCobranca.tipoCobranca)
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
      this.possoAlterarTipoCobranca = permissoes.alterar('tipoCobranca', this.tipoCobranca.usuarioCriador)
      this.possoExcluirTipoCobranca = permissoes.excluir('tipoCobranca', this.tipoCobranca.usuarioCriador)
    }
  },
  props: {
    id: {}
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
    possoGravarTipoCobranca: () => permissoes.gravar('tipoCobranca')
  }
}
</script>
