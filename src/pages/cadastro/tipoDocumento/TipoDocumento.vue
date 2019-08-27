<template>
  <div>
    <bodyTabs titulo="Cadastro de Tipos de Documento">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarTipoDocumento">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!tipoDocumento.tipoDocumento && possoGravarTipoDocumento" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="tipoDocumento.tipoDocumento && possoAlterarTipoDocumento" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirTipoDocumento">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <q-input label="Descrição"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.tipoDocumento.descricao.$error"
                  :error-message="errorDescricao"
                  autocomplete="off" type="text" v-model="tipoDocumento.descricao" @input="$v.tipoDocumento.descricao.$touch()" name="descricao"/>
              </div>
              <div class="col-md-3">
                <q-input
                  label="Código"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.tipoDocumento.codigo.$error"
                  error-message="Obrigatório"
                  autocomplete="off" type="text" v-model="tipoDocumento.codigo" @input="$v.tipoDocumento.codigo.$touch()" name="codigo"/>
              </div>
              <div class="col-md-3">
                <q-field class="form-input" label="Status"  stack-label borderless>
                  <q-option-group inline
                    v-model="tipoDocumento.status"
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

import ListaDeRegistros from './ListaTipoDocumentos.vue'
import { required } from 'vuelidate/lib/validators'
import TipoDocumento from './TipoDocumento'
import tipoDocumentoService from './TipoDocumentoService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'

export default {
  name: 'Cadastro-de-TipoDocumentos',
  components: {
    BodyTabs,
    ListaDeRegistros
  },
  data () {
    return {
      tipoDocumento: new TipoDocumento(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarTipoDocumento: false,
      possoExcluirTipoDocumento: false,
      timer: ''
    }
  },
  validations: {
    tipoDocumento: {
      codigo: {required},
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
          if (this.tipoDocumento.tipoDocumento) {
            opcao = 'alterar'
            id = this.tipoDocumento.tipoDocumento
          }
          let retorno = confereRegistro('categoriasDocumentos', 'descricao', opcao, id, 'categoriaDocumento', descricao)
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
    reset () {
      this.$v.tipoDocumento.$reset()
      this.tipoDocumento = new TipoDocumento()
      this.$router.push({name: 'tipoDocumento'})
      this.possoAlterarTipoDocumento = false
      this.possoExcluirTipoDocumento = false
    },
    carrega (id) {
      console.log('vou carregar o tipoDocumento')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      tipoDocumentoService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o tipoDocumento com sucesso')
          this.tipoDocumento = Object.assign({}, this.tipoDocumento, result.data)
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
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.$v.tipoDocumento.$touch()
        if (this.$v.tipoDocumento.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
          return
        }

        if (this.tipoDocumento.tipoDocumento && this.possoAlterarTipoDocumento) {
          console.log('estou alterando o form')
          tipoDocumentoService.altera(this.tipoDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoDocumento alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.tipoDocumento)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Documento alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.tipoDocumento.tipoDocumento && this.possoGravarTipoDocumento) {
          tipoDocumentoService.grava(this.tipoDocumento)
            .then(result => {
              console.log('tipoDocumento criado com sucesso')
              this.tipoDocumento.tipoDocumento = result.data.tipoDocumento.tipoDocumento
              this.tipoDocumento.usuarioCriador = result.data.tipoDocumento.usuarioCriador
              this.$router.push('/tipoDocumentos/tipoDocumento/' + result.data.tipoDocumento.tipoDocumento)
              this.$q.notify({
                type: 'positive',
                message: 'Tipo de Documento criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.tipoDocumento)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirTipoDocumento) {
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

          tipoDocumentoService.apaga(this.tipoDocumento.tipoDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('tipoDocumento removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Tipo de Documento removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.tipoDocumento.tipoDocumento)
              this.reset()
            })
        })
      } else {
        notify.semPermissao()
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarTipoDocumento = permissoes.alterar('tipoDocumento', this.tipoDocumento.usuarioCriador)
      this.possoExcluirTipoDocumento = permissoes.excluir('tipoDocumento', this.tipoDocumento.usuarioCriador)
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
    possoGravarTipoDocumento: () => permissoes.gravar('tipoDocumento')
  }
}
</script>
