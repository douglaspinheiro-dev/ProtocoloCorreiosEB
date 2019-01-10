<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Tipos de Cobrança</q-toolbar-title>
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarTipoCobranca">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!tipoCobranca.tipoCobranca && possoGravarTipoCobranca" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="tipoCobranca.tipoCobranca && possoAlterarTipoCobranca" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirTipoCobranca">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <q-field
                  label="Descrição"
                  orientation="vertical"
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.tipoCobranca.descricao.$error"
                  :error-label="errorDescricao"
                >
                  <q-input autocomplete="off" type="text" v-model="tipoCobranca.descricao" @input="$v.tipoCobranca.descricao.$touch()" name="descricao"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field
                  label="Valor"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="tel" v-model.lazy="tipoCobranca.valor" name="valor" prefix="R$" numeric-keyboard-toggle v-money="money"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Status" orientation="vertical">
                  <q-btn-group  class="fit">
                    <radio-button :status="tipoCobranca.status" @toggleRadioButton="toggleRadioButton"/>
                  </q-btn-group>
                </q-field>
              </div>
            </div>
          </form>

          <botao-mobile
            :id="tipoCobranca.tipoCobranca"
            :possoGravar="possoGravarTipoCobranca"
            :possoAlterar="possoAlterarTipoCobranca"
            :possoExcluir="possoExcluirTipoCobranca"
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
import ListaDeRegistros from 'src/components/menuRight/ListaTipoCobrancas.vue'
import { required } from 'vuelidate/lib/validators'
import TipoCobranca from 'src/services/tipoCobranca/TipoCobranca'
import tipoCobrancaService from 'src/services/tipoCobranca/TipoCobrancaService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
import VMoney from 'src/tools/money'

var timer

export default {
  name: 'Cadastro-de-TipoCobrancas',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    RadioButton,
    botaoMobile
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
          }).then(() => { }).catch(() => { })
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
        }).then(() => {
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
