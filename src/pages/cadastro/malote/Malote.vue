<template>
  <div>
    <bodyTabs titulo="Cadastro de Malotes">
      <template slot="tabHeader">
        <!-- Tabs - notice slot="title" -->
        <q-tab name="tab-1" icon="folder_shared" label="Cadastro" />
        <q-tab name="tab-2" icon="fas fa-map-signs" label="Documentos" v-if="malote.malote && possoAbrirMaloteDocumento"/>
      </template>

      <template slot="tabPanel">
        <!-- Targets -->
        <q-tab-panel name="tab-1">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarMalote">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!malote.malote && possoGravarMalote" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="malote.malote && possoAlterarMalote" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirMalote" >Excluir</q-btn>
              </div>
              <div class="col-md-6 text-right">
                <q-btn small type="button" icon="print" @click="imprimir" v-if="malote.malote && possoAlterarMalote">Imprimir</q-btn>
              </div>
            </div>

            <q-list>
              <q-expansion-item label="Dados Gerais" default-opened>
                <div class="row">
                  <div class="col-md-2">
                    <q-field label="Nº"  class="form-input" stack-label>
                      {{malote.protocolo}}
                    </q-field>
                  </div>
                  <div class="col-md-4">
                    <q-input stack-label
                      label="Data"
                      class="form-input"
                      hint="Obrigatório"
                      :error="$v.malote.data.$error"
                      error-message="Obrigatório"
                      type="date" v-model="malote.data" @input="$v.malote.data.$touch()" name="data"/>
                  </div>
                  <div class="col-md-3">
                    <q-input label="Lacre"
                      class="form-input"
                      :error="$v.malote.lacre.$error"
                      :error-message="errorLacre" autocomplete="off" type="tel" v-model="malote.lacre" @input="$v.malote.lacre.$touch()" name="lacre"/>
                  </div>

                  <div class="col-md-3">
                    <q-input label="Nº da Bolsa"
                      class="form-input" autocomplete="off" type="tel" v-model="malote.numeroBolsa" name="lacre"/>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <form-select
                      classe="form-input"
                      label="Rota"
                      :error="$v.malote.rota.$error"
                      error-message="Obrigatório"
                      hint="Obrigatório"
                      v-model="malote.rota"
                      :options="optionsRota"
                      @input="$v.malote.rota.$touch()"
                      required
                    />
                    <q-linear-progress indeterminate v-show="optionsLoading"/>
                  </div>
                </div>
              </q-expansion-item>
            </q-list>

          </form>

        </q-tab-panel>
        <q-tab-panel name="tab-2">
          <form-maloteDocumento :malote="malote.malote" :rota="malote.rota" ref="formMaloteDocumento"></form-maloteDocumento>
        </q-tab-panel>

      </template>
    </bodyTabs>
    <lista-de-registros />
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import ListaDeRegistros from './ListaMalotes.vue'
import { required } from 'vuelidate/lib/validators'
import Malote from './Malote'
import maloteService from './MaloteService'
import formMaloteDocumento from './MaloteDocumento.vue'
import confereRegistro from 'src/services/confereRegistro'
// import AwesomeMask from 'awesome-mask'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
// import RadioButton from 'src/components/form/radios/RadioButton'
import {mask} from 'vue-the-mask'
import Rota from 'src/pages/cadastro/rota/Rota'
import formSelect from 'src/components/form/select/QSelect'
import buscaMaloteService from 'src/pages/cadastro/malote/BuscaMaloteService'

export default {
  name: 'Malote',
  components: {
    ListaDeRegistros,
    formMaloteDocumento,
    formSelect,
    BodyTabs
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
      optionsLoading: false,
      timer: ''
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
          if (this.$refs.formMaloteDocumento) {
            this.$refs.formMaloteDocumento.listaDocumentos(id)
          }
        })
    },
    salvarAlterar () {
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.$v.malote.$touch()
        if (this.$v.malote.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
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
        }).onOk(() => {
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
        })
      } else {
        notify.semPermissao()
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarMalote = permissoes.alterar('malote')
      this.possoExcluirMalote = permissoes.excluir('malote')
    },
    imprimir () {
      buscaMaloteService.relatorio({
        protocolo: this.malote.protocolo,
        ano: this.malote.anoCadastro
      })
        .then(result => {
          this.$q.loading.hide()
          console.log('buscaMalote alterado com sucesso')
          // this.listaDocumentos()
          console.log(result.data)
          this.$store.commit('modalPdf/setModalPdf', {
            link: result.data.link,
            ativo: true
          })
          this.$q.notify({
            type: 'positive',
            message: 'Estes foram os registros encontrados.',
            timeout: 5000
          })
        })
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
