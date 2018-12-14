<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Grupo de Usuários</q-toolbar-title>
        <botao-menu-right/>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted>
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="folder shared" label="Cadastro"/>
      <q-tab slot="title" name="tab-2" icon="perm data setting" v-show="grupoUsuario.grupoUsuario" label="Permissões"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarGrupoUsuario">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!grupoUsuario.grupoUsuario && possoGravarGrupoUsuario" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="grupoUsuario.grupoUsuario && possoAlterarGrupoUsuario" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirGrupoUsuario">Excluir</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <q-field
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.grupoUsuario.codigo.$error"
                  :error-label="errorCodigo"
                  label="Código"
                  orientation="vertical"
                >
                  <q-input autocomplete="off" type="text" v-model="grupoUsuario.codigo" @blur="$v.grupoUsuario.codigo.$touch()" required name="codigo"/>
                </q-field>

              </div>
              <div class="col-md-6">
                <q-field
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.grupoUsuario.descricao.$error"
                  error-label="Preencha a descrição do grupo"
                  label="Descrição"
                  orientation="vertical"
                >
                  <q-input autocomplete="off" type="text" v-model="grupoUsuario.descricao" @input="$v.grupoUsuario.descricao.$touch()" required name="codigo"/>
                </q-field>

              </div>
            </div>
          </form>

          <botao-mobile
            :id="grupoUsuario.grupoUsuario"
            :possoGravar="possoGravarGrupoUsuario"
            :possoAlterar="possoAlterarGrupoUsuario"
            :possoExcluir="possoExcluirGrupoUsuario"
            @salvarAlterar="salvarAlterar"
            @excluir="excluir"
            @reset="reset"
          />
        </q-page>

      </q-tab-pane>

      <q-tab-pane name="tab-2" keep-alive>
        <form @submit.prevent="salvarAlterar">
          <div class="row barraBotoes">
            <div class="col-md-6 linhaBotoes">
              <q-btn small type="submit" icon="save"
                v-if="possoGravarGrupoUsuario || possoAlterarGrupoUsuario">Salvar</q-btn>
            </div>
          </div>
          <q-list>
            <q-collapsible icon="settings" label="Sistema">

              <q-collapsible icon="person" label="Usuários">
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
              </q-collapsible>

              <q-collapsible icon="supervisor account" label="Grupo de Usuários">
                <div class="row">
                  <div class="col-3">
                    <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="abrir" label="Abrir" />
                  </div>
                  <div class="col-3">
                    <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="inserir" label="Salvar" />
                  </div>
                  <div class="col-3">
                    <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="alterar" label="Alterar" />
                  </div>
                  <div class="col-3">
                    <q-toggle class="toggleGrupoUsuario" v-model="grupoUsuario.permissoes.grupoUsuario" val="excluir" label="Excluir" />
                  </div>
                </div>
              </q-collapsible>

            </q-collapsible>

            <q-collapsible icon="settings" label="Cadastros">

              <q-collapsible icon="person" label="Tipos de Documentos">
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
              </q-collapsible>

              <q-collapsible icon="fas fa-map-marked-alt" label="Endereços">
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
              </q-collapsible>

            </q-collapsible>

            <!-- <q-collapsible icon="folder shared" label="Cadastros">
              <q-collapsible icon="fas fa-id-card" label="Clientes">
                <q-collapsible icon="shopping cart" label="Cadastro de Clientes">
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
                </q-collapsible>

              </q-collapsible>

            </q-collapsible> -->

          </q-list>
        </form>
      </q-tab-pane>

    </q-tabs>
    <lista-de-registros/>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'
import ListaDeRegistros from 'src/components/menuRight/ListaGrupoUsuarios.vue'
import { required } from 'vuelidate/lib/validators'
import GrupoUsuario from 'src/services/grupoUsuario/GrupoUsuario'
import grupoUsuarioService from 'src/services/grupoUsuario/GrupoUsuarioService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
var timer

export default {
  name: 'Grupo-de-Usuarios',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    botaoMobile
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
          let codigo = value
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
          let retorno = confereRegistro('categoriasUsuarios', 'codigo', opcao, id, 'categoriaUsuario', codigo)
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
      this.$router.push({name: 'grupoUsuario'})
      this.possoAlterarGrupoUsuario = false
      this.possoExcluirGrupoUsuario = false
    },
    carrega (id) {
      console.log('vou carregar o grupoUsuario')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      grupoUsuarioService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
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
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(timer)
      timer = setTimeout(() => {
        this.$v.grupoUsuario.$touch()
        if (this.$v.grupoUsuario.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.grupoUsuario.grupoUsuario && this.possoAlterarGrupoUsuario) {
          console.log('estou alterando o form')
          grupoUsuarioService.altera(this.grupoUsuario)
            .then(result => {
              this.$q.loading.hide()
              console.log('grupousuario alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.grupoUsuario)
              this.$q.notify({
                type: 'positive',
                message: 'Grupo de Usuário alterado com sucesso.',
                timeout: 5000
              })

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
              this.$q.notify({
                type: 'positive',
                message: 'Grupo de Usuários criado com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.grupoUsuario)
              this.confereAlterarExcluir()
              // this.$q.loading.hide() nao precisa, pois ele carrega o registro em seguida
            })
        } else {
          notify.semPermissao()
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
          this.$q.loading.show({
            message: 'Processando sua requisição',
            messageColor: 'white',
            spinnerSize: 250, // in pixels
            spinnerColor: 'white'
          })

          grupoUsuarioService.apaga(this.grupoUsuario.grupoUsuario)
            .then(result => {
              this.$q.loading.hide()
              console.log('grupoUsuario removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Grupo de Usuário removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.grupoUsuario.grupoUsuario)
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
