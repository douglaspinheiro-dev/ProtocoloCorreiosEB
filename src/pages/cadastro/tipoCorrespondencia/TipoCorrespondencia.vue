<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Tipos de Correspondência</q-toolbar-title>
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarTipoCorrespondencia">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!tipoCorrespondencia.tipoCorrespondencia && possoGravarTipoCorrespondencia" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="tipoCorrespondencia.tipoCorrespondencia && possoAlterarTipoCorrespondencia" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirTipoCorrespondencia">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <q-field
                  label="Descrição"
                  orientation="vertical"
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.tipoCorrespondencia.descricao.$error"
                  :error-label="errorDescricao"
                >
                  <q-input autocomplete="off" type="text" v-model="tipoCorrespondencia.descricao" @input="$v.tipoCorrespondencia.descricao.$touch()" name="descricao"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field
                  label="Valor"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="tel" v-model.lazy="tipoCorrespondencia.valor" name="valor" prefix="R$" numeric-keyboard-toggle v-money="money"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Status" orientation="vertical">
                  <q-btn-group  class="fit">
                    <radio-button :status="tipoCorrespondencia.status" @toggleRadioButton="toggleRadioButton"/>
                  </q-btn-group>
                </q-field>
              </div>
            </div>
          </form>

          <botao-mobile
            :id="tipoCorrespondencia.tipoCorrespondencia"
            :possoGravar="possoGravarTipoCorrespondencia"
            :possoAlterar="possoAlterarTipoCorrespondencia"
            :possoExcluir="possoExcluirTipoCorrespondencia"
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
import ListaDeRegistros from 'src/components/menuRight/ListaTipoCorrespondencias.vue'
import { required } from 'vuelidate/lib/validators'
import TipoCorrespondencia from 'src/services/tipoCorrespondencia/TipoCorrespondencia'
import tipoCorrespondenciaService from 'src/services/tipoCorrespondencia/TipoCorrespondenciaService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
import VMoney from 'src/tools/money'

var timer

export default {
  name: 'Cadastro-de-TipoCorrespondencias',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    RadioButton,
    botaoMobile
  },
  data () {
    return {
      tipoCorrespondencia: new TipoCorrespondencia(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarTipoCorrespondencia: false,
      possoExcluirTipoCorrespondencia: false,
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
    tipoCorrespondencia: {
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
          if (this.tipoCorrespondencia.tipoCorrespondencia) {
            opcao = 'alterar'
            id = this.tipoCorrespondencia.tipoCorrespondencia
          }
          let retorno = confereRegistro('categoriasCorrespondencias', 'descricao', opcao, id, 'categoriaCorrespondencia', descricao)
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
      this.tipoCorrespondencia.status = !this.tipoCorrespondencia.status
    },
    reset () {
      this.$v.tipoCorrespondencia.$reset()
      this.tipoCorrespondencia = new TipoCorrespondencia()
      this.$router.push({name: 'tipoCorrespondencia'})
      this.possoAlterarTipoCorrespondencia = false
      this.possoExcluirTipoCorrespondencia = false
    },
    carrega (id) {
      console.log('vou carregar o tipoCorrespondencia')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      tipoCorrespondenciaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o tipoCorrespondencia com sucesso')
          this.tipoCorrespondencia = Object.assign({}, this.tipoCorrespondencia, result.data)
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
        this.$v.tipoCorrespondencia.$touch()
        if (this.$v.tipoCorrespondencia.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.tipoCorrespondencia.tipoCorrespondencia && this.possoAlterarTipoCorrespondencia) {
          console.log('estou alterando o form')
          tipoCorrespondenciaService.altera(this.tipoCorrespondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoCorrespondencia alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.tipoCorrespondencia)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Correspondência alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.tipoCorrespondencia.tipoCorrespondencia && this.possoGravarTipoCorrespondencia) {
          tipoCorrespondenciaService.grava(this.tipoCorrespondencia)
            .then(result => {
              console.log('tipoCorrespondencia criado com sucesso')
              this.tipoCorrespondencia.tipoCorrespondencia = result.data.tipoCorrespondencia.tipoCorrespondencia
              this.tipoCorrespondencia.usuarioCriador = result.data.tipoCorrespondencia.usuarioCriador
              this.$router.push('/tipoCorrespondencias/tipoCorrespondencia/' + result.data.tipoCorrespondencia.tipoCorrespondencia)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Correspondência criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.tipoCorrespondencia)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirTipoCorrespondencia) {
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

          tipoCorrespondenciaService.apaga(this.tipoCorrespondencia.tipoCorrespondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoCorrespondencia removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Tipo de Correspondência removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.tipoCorrespondencia.tipoCorrespondencia)
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
      this.possoAlterarTipoCorrespondencia = permissoes.alterar('tipoCorrespondencia', this.tipoCorrespondencia.usuarioCriador)
      this.possoExcluirTipoCorrespondencia = permissoes.excluir('tipoCorrespondencia', this.tipoCorrespondencia.usuarioCriador)
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
    possoGravarTipoCorrespondencia: () => permissoes.gravar('tipoCorrespondencia')
  }
}
</script>
