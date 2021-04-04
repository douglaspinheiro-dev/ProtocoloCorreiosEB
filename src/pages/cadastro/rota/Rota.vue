<template>
  <div>
    <bodyTabs titulo="Cadastro de Rotas">
      <template slot="tabHeader">
        <!-- Tabs - notice slot="title" -->
        <q-tab name="tab-1" icon="folder_shared" label="Cadastro" />
        <q-tab name="tab-2" icon="fas fa-map-signs" label="Endereços" v-if="rota.rota && possoAbrirRotaEndereco"/>
      </template>
      <template slot="tabPanel">
        <!-- Targets -->
        <q-tab-panel name="tab-1">

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
              <q-expansion-item label="Dados Gerais" default-opened>
                <div class="row">
                  <div class="col-md-6">
                    <q-input
                      label="Descrição"
                      class="form-input"
                      hint="Obrigatório"
                      :error="$v.rota.descricao.$error"
                      :error-message="errorDescricao"
                      autocomplete="off" type="text" v-model="rota.descricao" @input="$v.rota.descricao.$touch()" name="descricao"/>
                  </div>
                  <div class="col-md-3">
                    <q-input
                      label="Código"
                      class="form-input"
                      hint="Obrigatório"
                      :error="$v.rota.codigo.$error"
                      error-message="Obrigatório"
                      autocomplete="off" type="text" v-model="rota.codigo" @input="$v.rota.codigo.$touch()" name="codigo"/>
                  </div>
                  <div class="col-md-3">
                    <q-field class="form-input" label="Status" borderless stack-label>
                      <q-option-group inline
                        v-model="rota.status"
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
              </q-expansion-item>
            </q-list>

          </form>
        </q-tab-panel>
        <q-tab-panel name="tab-2">
          <form-rota-endereco :rota="rota.rota" ref="formRotaEndereco"></form-rota-endereco>
        </q-tab-panel>
      </template>
    </bodyTabs>
    <lista-de-registros />
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import ListaDeRegistros from './ListaRotas.vue'
import { required } from 'vuelidate/lib/validators'
import Rota from './Rota'
import rotaService from './RotaService'
import formRotaEndereco from './RotaEndereco.vue'
import confereRegistro from 'src/services/confereRegistro'
// import AwesomeMask from 'awesome-mask'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import { mask } from 'vue-the-mask'
import tools from 'src/tools'

export default {
  name: 'Rota',
  components: {
    ListaDeRegistros,
    formRotaEndereco,
    BodyTabs
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
      selectedTab: 'tab-1',
      timer: ''
    }
  },
  validations: {
    rota: {
      descricao: { required },
      codigo: {
        required,
        isUnique (value) {
          const codigo = value
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
          const retorno = confereRegistro('rotas', 'codigo', opcao, id, 'rota', codigo)
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
    reset () {
      this.$v.rota.$reset()
      this.rota = new Rota()
      this.$router.push({ name: 'rota' })
      this.possoAlterarRota = false
      this.possoExcluirRota = false
      this.possoAlterarRotaEndereco = false
      this.possoExcluirRotaEndereco = false
    },
    carrega (id) {
      console.log('vou carregar a rota')
      tools.Loadings.processando()

      rotaService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o rota com sucesso')
          this.rota = Object.assign({}, this.rota, result.data)
          this.confereAlterarExcluir()
          this.selectedTab = 'tab-1'
          if (this.$refs.formRotaEndereco) {
            this.$refs.formRotaEndereco.listaEnderecos(id)
          }
        })
    },
    salvarAlterar () {
      this.$v.rota.$touch()
      if (this.$v.rota.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.rota.rota && this.possoAlterarRota) {
          console.log('estou alterando o form')
          rotaService.altera(this.rota)
            .then(result => {
              tools.Loadings.hide()
              console.log('rota alterado com sucesso')
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.rota,
                id: 'rota'
              })
              tools.Notify.positive('Rota alterada com sucesso.')
            })
        } else if (!this.rota.rota && this.possoGravarRota) {
          rotaService.grava(this.rota)
            .then(result => {
              console.log('rota criado com sucesso')
              this.rota.rota = result.data.rota.rota
              this.rota.usuarioCriador = result.data.rota.usuarioCriador
              this.$router.push('/rotas/rota/' + result.data.rota.rota)
              tools.Notify.positive('Rota criada com sucesso.')
              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.rota)

              this.confereAlterarExcluir()
            })
        } else {
          tools.Notify.semPermissao()
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
        }).onOk(() => {
          tools.Loadings.processando()

          rotaService.apaga(this.rota.rota)
            .then(result => {
              tools.Loadings.hide()
              console.log('rota removido com sucesso')
              tools.Notify.negative('Rota removida com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.rota.rota,
                id: 'rota'
              })
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
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
    id: function (id) {
      if (id) this.carrega(id)
    }
  }
}
</script>
