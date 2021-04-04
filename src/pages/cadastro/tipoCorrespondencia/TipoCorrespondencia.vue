<template>
  <div>
    <bodyTabs titulo="Cadastro de Tipos de Correspondência">
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
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarTipoCorrespondencia">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!tipoCorrespondencia.tipoCorrespondencia && possoGravarTipoCorrespondencia" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="tipoCorrespondencia.tipoCorrespondencia && possoAlterarTipoCorrespondencia" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirTipoCorrespondencia">Excluir</q-btn>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <q-input
                  label="Descrição"
                  class="form-input"
                  hint="Obrigatório"
                  :error="$v.tipoCorrespondencia.descricao.$error"
                  :error-message="errorDescricao" autocomplete="off" type="text" v-model="tipoCorrespondencia.descricao" @input="$v.tipoCorrespondencia.descricao.$touch()" name="descricao"/>
              </div>
              <div class="col-md-4">
                <q-input
                  label="Valor"
                  class="form-input" autocomplete="off" type="tel" v-model.lazy="tipoCorrespondencia.valor" name="valor" prefix="R$" numeric-keyboard-toggle v-money="money"/>
              </div>
              <div class="col-md-4">
                <q-field class="form-input" label="Status" borderless stack-label >
                  <q-option-group inline
                    v-model="tipoCorrespondencia.status"
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

import ListaDeRegistros from './ListaTipoCorrespondencias.vue'
import { required } from 'vuelidate/lib/validators'
import TipoCorrespondencia from './TipoCorrespondencia'
import tipoCorrespondenciaService from './TipoCorrespondenciaService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import VMoney from 'src/tools/money'
import tools from 'src/tools'

export default {
  name: 'Cadastro-de-TipoCorrespondencias',
  components: {
    BodyTabs,
    ListaDeRegistros
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
      },
      timer: ''
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
          const descricao = value
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
          const retorno = confereRegistro('categoriasCorrespondencias', 'descricao', opcao, id, 'categoriaCorrespondencia', descricao)
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
      this.$v.tipoCorrespondencia.$reset()
      this.tipoCorrespondencia = new TipoCorrespondencia()
      this.$router.push({ name: 'tipoCorrespondencia' })
      this.possoAlterarTipoCorrespondencia = false
      this.possoExcluirTipoCorrespondencia = false
    },
    carrega (id) {
      console.log('vou carregar o tipoCorrespondencia')
      tools.Loadings.processando()

      tipoCorrespondenciaService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o tipoCorrespondencia com sucesso')
          this.tipoCorrespondencia = Object.assign({}, this.tipoCorrespondencia, result.data)
          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.tipoCorrespondencia.$touch()
      if (this.$v.tipoCorrespondencia.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.tipoCorrespondencia.tipoCorrespondencia && this.possoAlterarTipoCorrespondencia) {
          console.log('estou alterando o form')
          tipoCorrespondenciaService.altera(this.tipoCorrespondencia)
            .then(result => {
              tools.Loadings.hide()
              console.log('tipoCorrespondencia alterado com sucesso')
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.tipoCorrespondencia,
                id: 'tipoCorrespondencia'
              })
              tools.Notify.positive('Tipo de Correspondência alterado com sucesso.')
            })
        } else if (!this.tipoCorrespondencia.tipoCorrespondencia && this.possoGravarTipoCorrespondencia) {
          tipoCorrespondenciaService.grava(this.tipoCorrespondencia)
            .then(result => {
              console.log('tipoCorrespondencia criado com sucesso')
              this.tipoCorrespondencia.tipoCorrespondencia = result.data.tipoCorrespondencia.tipoCorrespondencia
              this.tipoCorrespondencia.usuarioCriador = result.data.tipoCorrespondencia.usuarioCriador
              this.$router.push('/tipoCorrespondencias/tipoCorrespondencia/' + result.data.tipoCorrespondencia.tipoCorrespondencia)
              tools.Notify.positive('Tipo de Correspondência criado com sucesso.')

              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.tipoCorrespondencia)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
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
        }).onOk(() => {
          tools.Loadings.processando()

          tipoCorrespondenciaService.apaga(this.tipoCorrespondencia.tipoCorrespondencia)
            .then(result => {
              tools.Loadings.hide()
              console.log('tipoCorrespondencia removido com sucesso')
              tools.Notify.negative('Tipo de Correspondência removido com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.tipoCorrespondencia.tipoCorrespondencia,
                id: 'tipoCorrespondencia'
              })
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
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
    id: function (id) {
      if (id) this.carrega(id)
    }
  },
  computed: {
    possoGravarTipoCorrespondencia: () => permissoes.gravar('tipoCorrespondencia')
  }
}
</script>
