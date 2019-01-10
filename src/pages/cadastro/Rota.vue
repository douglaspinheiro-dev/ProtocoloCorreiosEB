<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Rotas</q-toolbar-title>
        <botao-menu-right/>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted v-model="selectedTab">
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="fas fa-map-marked-alt" label="Cadastro"/>
      <q-tab slot="title" name="tab-2" icon="fas fa-map-signs" label="Endereços" v-if="rota.rota && possoAbrirRotaEndereco"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarRota">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!rota.rota && possoGravarRota" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="rota.rota && possoAlterarRota" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirRota" >Excluir</q-btn>
              </div>
            </div>

            <q-list>
              <q-collapsible label="Dados Gerais" opened>
                <div class="row">
                  <div class="col-md-6">
                    <q-field
                      label="Descrição"
                      orientation="vertical"
                      class="form-input"
                      helper="Obrigatório"
                      :error="$v.rota.descricao.$error"
                      :error-label="errorDescricao"
                    >
                      <q-input autocomplete="off" type="text" v-model="rota.descricao" @input="$v.rota.descricao.$touch()" name="descricao"/>
                    </q-field>
                  </div>
                  <div class="col-md-3">
                    <q-field
                      label="Código"
                      orientation="vertical"
                      class="form-input"
                      helper="Obrigatório"
                      :error="$v.rota.codigo.$error"
                      error-label="Obrigatório"
                    >
                      <q-input autocomplete="off" type="text" v-model="rota.codigo" @input="$v.rota.codigo.$touch()" name="codigo"/>
                    </q-field>
                  </div>
                  <div class="col-md-3">
                    <q-field class="form-input" label="Status" orientation="vertical">
                      <q-btn-group  class="fit">
                        <radio-button :status="rota.status" @toggleRadioButton="toggleRadioButton"/>
                      </q-btn-group>
                    </q-field>
                  </div>
                </div>
              </q-collapsible>

            </q-list>

          </form>
          <botao-mobile
            :id="rota.rota"
            :possoGravar="possoGravarRota"
            :possoAlterar="possoAlterarRota"
            :possoExcluir="possoExcluirRota"
            @salvarAlterar="salvarAlterar"
            @excluir="excluir"
            @reset="reset"
          />
        </q-page>

      </q-tab-pane>

      <q-tab-pane name="tab-2" v-if="rota.rota && possoAbrirRotaEndereco">
        <form-rotaEndereco :rota="rota.rota"></form-rotaEndereco>

      </q-tab-pane>

    </q-tabs>
    <lista-de-registros/>

  </div>
</template>

<script>
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'
import ListaDeRegistros from 'src/components/menuRight/ListaRotas.vue'
import { required } from 'vuelidate/lib/validators'
import Rota from 'src/services/rota/Rota'
import rotaService from 'src/services/rota/RotaService'
import formRotaEndereco from 'src/components/RotaEndereco'
import confereRegistro from 'src/services/confereRegistro'
var timer
// import AwesomeMask from 'awesome-mask'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from '../../tools/Notify'
import RadioButton from 'src/components/form/radios/RadioButton'
import {mask} from 'vue-the-mask'
import botaoMobile from 'src/components/QFab/QFab'

export default {
  name: 'Rota',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    RadioButton,
    formRotaEndereco,
    botaoMobile
  },
  directives: { mask },
  data () {
    return {
      rota: new Rota(),
      errorCodigo: 'Preencha o código do grupo',
      errorDescricao: 'Preencha a descrição do grupo',
      permissoes: [],
      possoAlterarRota: false,
      possoExcluirRota: false,
      selectedTab: 'tab-1'
    }
  },
  validations: {
    rota: {
      descricao: {required},
      codigo: {
        required,
        isUnique (value) {
          let codigo = value
          // se for vazio, passo a bola pro validador required
          if (codigo === '') {
            return true
          }
          let opcao = 'gravar'
          let id = ''
          if (this.rota.rota) {
            opcao = 'alterar'
            id = this.rota.rota
          }
          let retorno = confereRegistro('rotas', 'codigo', opcao, id, 'rota', codigo)
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
    },
    rotaEndereco: {
      nomeCompleto: {
        required
      },
      cargo: {
        required
      }
    }
  },
  methods: {
    toggleRadioButton () {
      this.rota.status = !this.rota.status
    },
    reset () {
      this.$v.rota.$reset()
      this.rota = new Rota()
      this.$router.push({name: 'rota'})
      this.possoAlterarRota = false
      this.possoExcluirRota = false
      this.possoAlterarRotaEndereco = false
      this.possoExcluirRotaEndereco = false
    },
    carrega (id) {
      console.log('vou carregar a rota')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      rotaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o rota com sucesso')
          this.rota = Object.assign({}, this.rota, result.data)
          this.confereAlterarExcluir()
          this.selectedTab = 'tab-1'
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
        this.$v.rota.$touch()
        if (this.$v.rota.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.rota.rota && this.possoAlterarRota) {
          console.log('estou alterando o form')
          rotaService.altera(this.rota)
            .then(result => {
              this.$q.loading.hide()
              console.log('rota alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.rota)
              this.$q.notify({
                type: 'positive',
                message: 'Rota alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.rota.rota && this.possoGravarRota) {
          rotaService.grava(this.rota)
            .then(result => {
              console.log('rota criado com sucesso')
              this.rota.rota = result.data.rota.rota
              this.rota.usuarioCriador = result.data.rota.usuarioCriador
              this.$router.push('/rotas/rota/' + result.data.rota.rota)
              this.$q.notify({
                type: 'positive',
                message: 'Rota criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.rota)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirRota) {
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

          rotaService.apaga(this.rota.rota)
            .then(result => {
              this.$q.loading.hide()
              console.log('rota removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Rota removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.rota.rota)
              // this.$store.commit('menuRight/removeRegistro', this.id)
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
      this.possoAlterarRota = permissoes.alterar('rota', this.rota.usuarioCriador)
      this.possoExcluirRota = permissoes.excluir('rota', this.rota.usuarioCriador)
    }
  },
  computed: {
    possoGravarRota: () => permissoes.gravar('rota'),
    possoAbrirRotaEndereco: () => permissoes.abrir('rotaEndereco')
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
  }
}
</script>
