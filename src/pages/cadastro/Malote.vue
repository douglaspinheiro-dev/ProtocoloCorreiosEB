<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Malotes</q-toolbar-title>
        <botao-menu-right/>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted v-model="selectedTab">
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="fas fa-map-marked-alt" label="Cadastro"/>
      <q-tab slot="title" name="tab-2" icon="fas fa-map-signs" label="Documentos" v-if="malote.malote && possoAbrirMaloteDocumento"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarMalote">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!malote.malote && possoGravarMalote" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="malote.malote && possoAlterarMalote" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirMalote" >Excluir</q-btn>
              </div>
            </div>

            <q-list>
              <q-collapsible label="Dados Gerais" opened>
                <div class="row">
                  <div class="col-md-2">
                    <q-field label="Nº" orientation="vertical" class="form-input">
                      {{malote.protocolo}}
                    </q-field>
                  </div>
                  <div class="col-md-4">
                    <q-field
                      label="Data"
                      orientation="vertical"
                      class="form-input"
                      helper="Obrigatório"
                      :error="$v.malote.data.$error"
                      error-label="Obrigatório"
                    >
                      <q-input type="date" v-model="malote.data" @input="$v.malote.data.$touch()" name="data"/>
                    </q-field>
                  </div>
                  <div class="col-md-3">
                    <q-field
                      label="Lacre"
                      orientation="vertical"
                      class="form-input"
                      :error="$v.malote.lacre.$error"
                      :error-label="errorLacre"
                    >
                      <q-input autocomplete="off" type="tel" v-model="malote.lacre" @input="$v.malote.lacre.$touch()" name="lacre"/>
                    </q-field>
                  </div>

                  <div class="col-md-3">
                    <q-field
                      label="Nº da Bolsa"
                      orientation="vertical"
                      class="form-input"
                    >
                      <q-input autocomplete="off" type="tel" v-model="malote.numeroBolsa" name="lacre"/>
                    </q-field>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <q-field class="form-input" label="Rota" orientation="vertical"
                      :error="$v.malote.rota.$error"
                      error-label="Obrigatório"
                      helper="Obrigatório"
                    >
                      <q-select
                        v-model="malote.rota"
                        :options="optionsRota"
                        filter
                        autofocus-filter
                        filter-placeholder="Selecione a rota"
                        name="select"
                        @input="$v.malote.rota.$touch()"
                      />
                      <q-progress indeterminate v-show="optionsLoading"/>
                    </q-field>
                  </div>
                </div>
              </q-collapsible>

            </q-list>

          </form>
          <botao-mobile
            :id="malote.malote"
            :possoGravar="possoGravarMalote"
            :possoAlterar="possoAlterarMalote"
            :possoExcluir="possoExcluirMalote"
            @salvarAlterar="salvarAlterar"
            @excluir="excluir"
            @reset="reset"
          />
        </q-page>

      </q-tab-pane>

      <q-tab-pane name="tab-2" v-if="malote.malote && possoAbrirMaloteDocumento">
        <form-maloteDocumento :malote="malote.malote" :rota="malote.rota"></form-maloteDocumento>

      </q-tab-pane>

    </q-tabs>
    <lista-de-registros/>

  </div>
</template>

<script>
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'
import ListaDeRegistros from 'src/components/menuRight/ListaMalotes.vue'
import { required } from 'vuelidate/lib/validators'
import Malote from 'src/services/malote/Malote'
import maloteService from 'src/services/malote/MaloteService'
import formMaloteDocumento from 'src/components/MaloteDocumento'
import confereRegistro from 'src/services/confereRegistro'
var timer
// import AwesomeMask from 'awesome-mask'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from '../../tools/Notify'
// import RadioButton from 'src/components/form/radios/RadioButton'
import {mask} from 'vue-the-mask'
import botaoMobile from 'src/components/QFab/QFab'
import Rota from 'src/services/rota/Rota'

export default {
  name: 'Malote',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    // RadioButton,
    formMaloteDocumento,
    botaoMobile
  },
  directives: { mask },
  data () {
    return {
      malote: new Malote(),
      rota: new Rota(),
      errorLacre: 'Preencha a lacre do malote',
      possoAlterarMalote: false,
      possoExcluirMalote: false,
      selectedTab: 'tab-1',
      optionsRota: [],
      optionsLoading: false
    }
  },
  validations: {
    malote: {
      rota: { required },
      data: { required },
      lacre: {
        isUnique (value) {
          let lacre = value
          // se for vazio, passo a bola pro validador required
          if (lacre === '') {
            return true
          }
          let opcao = 'gravar'
          let id = ''
          if (this.malote.malote) {
            opcao = 'alterar'
            id = this.malote.malote
          }
          let retorno = confereRegistro('malotes', 'lacre', opcao, id, 'malote', lacre)
            .then(result => {
              if (result.status === 200) {
                if (result.data.resposta === true) {
                  return true
                } else {
                  this.errorLacre = 'Este lacre ja está em uso, escolha outro'
                  return false
                }
              }
            })
          return retorno
        }
      }
    },
    maloteDocumento: {
      nomeCompleto: {
        required
      },
      cargo: {
        required
      }
    }
  },
  methods: {
    reset () {
      this.$v.malote.$reset()
      this.malote = new Malote()
      this.$router.push({name: 'malote'})
      this.possoAlterarMalote = false
      this.possoExcluirMalote = false
      this.possoAlterarMaloteDocumento = false
      this.possoExcluirMaloteDocumento = false
    },
    carrega (id) {
      console.log('vou carregar a malote')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      maloteService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o malote com sucesso')
          this.malote = Object.assign({}, this.malote, result.data)
          console.log(result.data)

          this.$root.$emit('alteraUnicoRegistro', this.malote)

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
        this.$v.malote.$touch()
        if (this.$v.malote.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.malote.malote && this.possoAlterarMalote) {
          console.log('estou alterando o form')
          maloteService.altera(this.malote)
            .then(result => {
              this.$q.loading.hide()
              console.log('malote alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.malote)
              this.$q.notify({
                type: 'positive',
                message: 'Malote alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.malote.malote && this.possoGravarMalote) {
          maloteService.grava(this.malote)
            .then(result => {
              console.log('malote criado com sucesso')
              console.log(result.data)

              this.malote.malote = result.data.malote.malote
              this.malote.usuarioCriador = result.data.malote.usuarioCriador

              let rotaDescricao = this.optionsRota.filter(rota => rota.value === this.malote.rota)
              this.malote.rotaDescricao = rotaDescricao[0].label
              this.$router.push('/malotes/malote/' + result.data.malote.malote)
              this.$q.notify({
                type: 'positive',
                message: 'Malote criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.malote)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirMalote) {
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

          maloteService.apaga(this.malote.malote)
            .then(result => {
              this.$q.loading.hide()
              console.log('malote removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Malote removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.malote.malote)
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
      this.possoAlterarMalote = permissoes.alterar('malote')
      this.possoExcluirMalote = permissoes.excluir('malote')
    }
  },
  computed: {
    possoGravarMalote: () => permissoes.gravar('malote'),
    possoAbrirMaloteDocumento: () => permissoes.abrir('maloteDocumento')
  },
  mounted () {
    this.optionsLoading = true
    maloteService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsRota = this.rota.setOptions(result.data.rotas)
      })
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
