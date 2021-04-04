<template>
  <div>
    <bodyTabs titulo="Grupo de Usuários">
      <template slot="tabHeader">
        <!-- Tabs - notice slot="title" -->
        <q-tab default slot="title" name="tab-1" icon="folder_shared" label="Cadastro"/>
        <q-tab slot="title" name="tab-2" icon="perm data setting" v-show="grupoUsuario.grupoUsuario" label="Permissões"/>
      </template>

      <template slot="tabPanel">
        <!-- Targets -->
        <q-tab-panel name="tab-1">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <barra-de-botoes
                @reset="reset"
                @excluir="excluir"
                @submit="salvarAlterar"
                :id="grupoUsuario.grupoUsuario"
                :possoGravar="possoGravarGrupoUsuario"
                :possoAlterar="possoAlterarGrupoUsuario"
                :possoExcluir="possoExcluirGrupoUsuario"
              />
            </div>

            <div class="row">
              <div class="col-md-6">
                <q-input class="form-input"
                  hint="Obrigatório"
                  :error="$v.grupoUsuario.codigo.$error"
                  :error-message="errorCodigo"
                  label="Código" autocomplete="off" type="text" v-model="grupoUsuario.codigo" @blur="$v.grupoUsuario.codigo.$touch()" required name="codigo"/>
              </div>
              <div class="col-md-6">
                <q-input class="form-input"
                  hint="Obrigatório"
                  :error="$v.grupoUsuario.descricao.$error"
                  error-message="Preencha a descrição do grupo"
                  label="Descrição" autocomplete="off" type="text" v-model="grupoUsuario.descricao" @input="$v.grupoUsuario.descricao.$touch()" required name="codigo"/>
              </div>
            </div>
          </form>

        </q-tab-panel>
        <q-tab-panel name="tab-2">
          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="submit" icon="save"
                  v-if="possoGravarGrupoUsuario || possoAlterarGrupoUsuario">Salvar</q-btn>
              </div>
            </div>
            <q-list>
              <q-expansion-item icon="settings" label="Sistema">

                <q-expansion-item icon="person" label="Usuários" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.usuario" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.usuario" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.usuario" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.usuario" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="supervisor_account" label="Grupo de Usuários" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

              </q-expansion-item>

              <q-expansion-item icon="folder_shared" label="Cadastros">

                <q-expansion-item icon="fas fa-file-contract" label="Tipos de Documentos" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoDocumento" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoDocumento" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoDocumento" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoDocumento" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="fas fa-envelope" label="Tipos de Correspondências" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCorrespondencia" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCorrespondencia" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCorrespondencia" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCorrespondencia" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="attach_money" label="Tipos de Cobranças" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCobranca" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCobranca" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCobranca" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.tipoCobranca" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="fas fa-map-marked-alt" label="Endereços" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.endereco" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.endereco" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.endereco" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.endereco" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="work_outline" label="Setores Internos" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.setor" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.setor" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.setor" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.setor" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="fas fa-file-alt" label="Protocolo de Entrada" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.protocoloEntrada" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.protocoloEntrada" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.protocoloEntrada" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.protocoloEntrada" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="fas fa-map-marked-alt" label="Rotas" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.rota" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.rota" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.rota" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.rota" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="move_to_inbox" label="Malotes" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.malote" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.malote" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.malote" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.malote" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

                <q-expansion-item icon="mail_outline" label="Correspondências" :header-inset-level="1" :content-inset-level="2">
                  <div class="row">
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.correspondencia" val="abrir" label="Abrir" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.correspondencia" val="inserir" label="Salvar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.correspondencia" val="alterar" label="Alterar" />
                    </div>
                    <div class="col-3">
                      <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.correspondencia" val="excluir" label="Excluir" />
                    </div>
                  </div>
                </q-expansion-item>

              </q-expansion-item>

              <!-- <q-expansion-item icon="folder shared" label="Cadastros">
                <q-expansion-item icon="fas fa-id-card" label="Clientes">
                  <q-expansion-item icon="shopping cart" label="Cadastro de Clientes">
                    <div class="row">
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="abrir" label="Abrir" />
                      </div>
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="inserir" label="Salvar" />
                      </div>
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="alterar" label="Alterar Próprio" />
                      </div>
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="alterarOutros" label="Alterar Outros" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="excluir" label="Excluir Próprio" />
                      </div>
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="excluirOutros" label="Excluir Outros" />
                      </div>
                      <div class="col-md-3">
                        <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.cliente" val="relatorios" label="Relatórios" />
                      </div>
                    </div>
                  </q-expansion-item>

                </q-expansion-item>

              </q-expansion-item> -->

            </q-list>
          </form>
        </q-tab-panel>

      </template>
    </bodyTabs>
    <lista-de-registros />

  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'
import BarraDeBotoes from 'src/components/form/BarraDeBotoes'
import { mapGetters } from 'vuex'
import ListaDeRegistros from './ListaGrupoUsuarios.vue'
import { required } from 'vuelidate/lib/validators'
import GrupoUsuario from './GrupoUsuario'
import grupoUsuarioService from './GrupoUsuarioService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import tools from 'src/tools'

let timer

export default {
  name: 'Grupo-de-Usuarios',
  components: {
    BodyTabs,
    ListaDeRegistros,
    BarraDeBotoes
  },
  data () {
    return {
      grupoUsuario: new GrupoUsuario(),
      errorCodigo: 'Preencha o código do grupo',
      errorDescricao: 'Preencha a descrição do grupo',
      permissoes: [],
      possoAlterarGrupoUsuario: false,
      possoExcluirGrupoUsuario: false
    }
  },
  validations: {
    grupoUsuario: {
      codigo: {
        required,
        isUnique (value) {
          const codigo = value
          // se for vazio, passo a bola pro validador required
          if (codigo === '') {
            this.errorCodigo = 'Preencha o código do grupo'
            return true
          }
          let opcao = 'gravar'
          let id = ''
          if (this.grupoUsuario.grupoUsuario) {
            opcao = 'alterar'
            id = this.grupoUsuario.grupoUsuario
          }
          const retorno = confereRegistro('categoriasUsuarios', 'codigo', opcao, id, 'categoriaUsuario', codigo)
            .then(result => {
              if (result.status === 200) {
                if (result.data.resposta === true) {
                  return true
                } else {
                  this.errorCodigo = 'Este código já está em uso, escolha um diferente'
                  return false
                }
              }
            })
          return retorno
        }
      },
      descricao: {
        required
      }
    }
  },
  methods: {
    reset () {
      this.$v.grupoUsuario.$reset()
      this.grupoUsuario = new GrupoUsuario()
      this.$router.push({ name: 'grupoUsuario' })
      this.possoAlterarGrupoUsuario = false
      this.possoExcluirGrupoUsuario = false
    },
    carrega (id) {
      console.log('vou carregar o grupoUsuario')
      tools.Loadings.processando()

      grupoUsuarioService
        .seleciona(id)
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o grupoUsuario com sucesso')
          this.grupoUsuario.codigo = result.data.codigo
          this.grupoUsuario.descricao = result.data.descricao
          this.grupoUsuario.grupoUsuario = result.data.grupoUsuario
          this.grupoUsuario.usuarioCriador = result.data.usuarioCriador
          this.grupoUsuario.permissoes = Object.assign({}, this.grupoUsuario.permissoes, result.data.permissoes)
          console.log(this.grupoUsuario.permissoes.usuario)
          this.confereAlterarExcluir()
        })
    },
    salvarAlterar () {
      this.$v.grupoUsuario.$touch()
      if (this.$v.grupoUsuario.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(timer)
      timer = setTimeout(() => {
        if (this.grupoUsuario.grupoUsuario && this.possoAlterarGrupoUsuario) {
          console.log('estou alterando o form')
          grupoUsuarioService.altera(this.grupoUsuario)
            .then(result => {
              tools.Loadings.hide()
              console.log('grupousuario alterado com sucesso')
              this.$store.commit('listaDeRegistros/alteraUnicoRegistro', {
                registro: this.grupoUsuario,
                id: 'grupoUsuario'
              })

              tools.Notify.positive('Grupo de Usuário alterado com sucesso.')

              if (this.getCategoriaUsuario === this.grupoUsuario.grupoUsuario) {
                this.$store.commit('login/setPermissoes', result.data.permissoes)
              }
            })
        } else if (!this.grupoUsuario.grupoUsuario && this.possoGravarGrupoUsuario) {
          grupoUsuarioService.grava(this.grupoUsuario)
            .then(result => {
              console.log('grupoUsuario criado com sucesso')
              this.grupoUsuario.grupoUsuario = result.data.grupoUsuario.grupoUsuario
              this.grupoUsuario.usuarioCriador = result.data.grupoUsuario.usuarioCriador
              this.$router.push('/grupousuarios/grupousuario/' + result.data.grupoUsuario.grupoUsuario)
              tools.Notify.positive('Grupo de Usuário criado com sucesso.')

              this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.grupoUsuario)

              this.confereAlterarExcluir()
              // tools.Loadings.hide() nao precisa, pois ele carrega o registro em seguida
            })
        } else {
          tools.Notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirGrupoUsuario) {
        this.$q.dialog({
          title: 'Tem certeza?',
          message: 'Ao confirmar esta operação, não poderá desfazer.',
          ok: 'Sim, excluir',
          cancel: 'Cancelar'
        }).then(() => {
          tools.Loadings.processando()

          grupoUsuarioService.apaga(this.grupoUsuario.grupoUsuario)
            .then(result => {
              tools.Loadings.hide()
              console.log('grupoUsuario removido com sucesso')
              tools.Notify.negative('Grupo de Usuário removido com sucesso.')

              this.$store.commit('listaDeRegistros/removeRegistro', {
                registro: this.grupoUsuario.grupoUsuario,
                id: 'grupoUsuario'
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
      this.possoAlterarGrupoUsuario = permissoes.alterar('grupoUsuario', this.grupoUsuario.usuarioCriador)
      this.possoExcluirGrupoUsuario = permissoes.excluir('grupoUsuario', this.grupoUsuario.usuarioCriador)
    }
  },
  props: {
    id: {}
  },
  watch: {
    id: function (id) {
      if (id) { this.carrega(id) }
    }
  },
  computed: {
    ...mapGetters({
      getCategoriaUsuario: 'login/getCategoriaUsuario'
    }),
    possoGravarGrupoUsuario: () => permissoes.gravar('grupoUsuario')
  }
}
</script>

<style scoped>
.toggleGrupoUsuario{
  margin-top: 5px;
}
</style>
