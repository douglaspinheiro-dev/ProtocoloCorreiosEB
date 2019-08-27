<template>
  <div>
    <bodyTabs titulo="Cadastro de Setores Internos">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarSetor">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!setor.setor && possoGravarSetor" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="setor.setor && possoAlterarSetor" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirSetor">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <q-input label="Descrição"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.setor.descricao.$error"
                  :error-message="errorDescricao" autocomplete="off" type="text" v-model="setor.descricao" @input="$v.setor.descricao.$touch()" name="descricao"/>
              </div>
              <div class="col-md-3">
                <q-input label="Código"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.setor.codigo.$error"
                  error-message="Obrigatório" autocomplete="off" type="text" v-model="setor.codigo" @input="$v.setor.codigo.$touch()" name="codigo"/>
              </div>
              <div class="col-md-3">
                <q-field class="form-input" label="Status" stack-label borderless>
                  <q-option-group inline
                    v-model="setor.status"
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

import ListaDeRegistros from './ListaSetores.vue'
import { required } from 'vuelidate/lib/validators'
import Setor from './Setor'
import setorService from './SetorService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'

export default {
  name: 'Cadastro-de-Setores',
  components: {
    ListaDeRegistros,
    BodyTabs
  },
  data () {
    return {
      setor: new Setor(),
      errorDescricao: 'Preencha a descrição',
      possoAlterarSetor: false,
      possoExcluirSetor: false,
      timer: ''
    }
  },
  validations: {
    setor: {
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
          if (this.setor.setor) {
            opcao = 'alterar'
            id = this.setor.setor
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
    toggleRadioButton () {
      this.setor.status = !this.setor.status
    },
    reset () {
      this.$v.setor.$reset()
      this.setor = new Setor()
      this.$router.push({name: 'setor'})
      this.possoAlterarSetor = false
      this.possoExcluirSetor = false
    },
    carrega (id) {
      console.log('vou carregar o setor')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      setorService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o setor com sucesso')
          this.setor = Object.assign({}, this.setor, result.data)
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
        this.$v.setor.$touch()
        if (this.$v.setor.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
          return
        }

        if (this.setor.setor && this.possoAlterarSetor) {
          console.log('estou alterando o form')
          setorService.altera(this.setor)
            .then(result => {
              this.$q.loading.hide()
              console.log('setor alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.setor)
              this.$q.notify({
                type: 'positive',
                message: 'Setor alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.setor.setor && this.possoGravarSetor) {
          setorService.grava(this.setor)
            .then(result => {
              console.log('setor criado com sucesso')
              this.setor.setor = result.data.setor.setor
              this.setor.usuarioCriador = result.data.setor.usuarioCriador
              this.$router.push('/setores/setor/' + result.data.setor.setor)
              this.$q.notify({
                type: 'positive',
                message: 'Setor criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.setor)
              this.confereAlterarExcluir()
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirSetor) {
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

          setorService.apaga(this.setor.setor)
            .then(result => {
              this.$q.loading.hide()
              console.log('setor removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Setor removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.setor.setor)
              this.reset()
            })
        })
      } else {
        notify.semPermissao()
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarSetor = permissoes.alterar('setor', this.setor.usuarioCriador)
      this.possoExcluirSetor = permissoes.excluir('setor', this.setor.usuarioCriador)
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
    possoGravarSetor: () => permissoes.gravar('setor')
  }
}
</script>
