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
import VMoney from 'src/tools/money'
import tools from 'src/tools'

let timer

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
          const descricao = value
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
          const retorno = confereRegistro('categoriasCobrancas', 'descricao', opcao, id, 'categoriaCobranca', descricao)
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
      this.$router.push({ name: 'tipoCobranca' })
      this.possoAlterarTipoCobranca = false
      this.possoExcluirTipoCobranca = false
    },
    carrega (id) {
      console.log('vou carregar o tipoCobranca')
      tools.Loadings.processando()

      tipoCobrancaService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o tipoCobranca com sucesso')
          this.tipoCobranca = Object.assign({}, this.tipoCobranca, result.data)
          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.tipoCobranca.$touch()
      if (this.$v.tipoCobranca.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()
      clearTimeout(timer)
      timer = setTimeout(() => {
        if (this.tipoCobranca.tipoCobranca && this.possoAlterarTipoCobranca) {
          console.log('estou alterando o form')
          tipoCobrancaService.altera(this.tipoCobranca)
            .then(result => {
              tools.Loadings.hide()
              console.log('tipoCobranca alterado com sucesso')
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.tipoCobranca,
                id: 'tipoCobranca'
              })
              tools.Notify.positive('Tipo de Cobrança alterado com sucesso.')
            })
        } else if (!this.tipoCobranca.tipoCobranca && this.possoGravarTipoCobranca) {
          tipoCobrancaService.grava(this.tipoCobranca)
            .then(result => {
              console.log('tipoCobranca criado com sucesso')
              this.tipoCobranca.tipoCobranca = result.data.tipoCobranca.tipoCobranca
              this.tipoCobranca.usuarioCriador = result.data.tipoCobranca.usuarioCriador
              this.$router.push('/tipoCobrancas/tipoCobranca/' + result.data.tipoCobranca.tipoCobranca)
              tools.Notify.positive('Tipo de Cobrança criado com sucesso.')

              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.tipoCobranca)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
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
          tools.Loadings.processando()

          tipoCobrancaService.apaga(this.tipoCobranca.tipoCobranca)
            .then(result => {
              tools.Loadings.hide()
              console.log('tipoCobranca removido com sucesso')
              tools.Notify.negative('Tipo de Cobrança removido com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.tipoCobranca.tipoCobranca,
                id: 'tipoCobranca'
              })
              this.reset()
            })
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
      } else {
        tools.Notify.semPermissao()
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
    id: function (id) {
      if (id) this.carrega(id)
    }
  },
  computed: {
    possoGravarTipoCobranca: () => permissoes.gravar('tipoCobranca')
  }
}
</script>
