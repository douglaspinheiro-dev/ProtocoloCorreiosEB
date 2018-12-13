<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left/>
        <q-toolbar-title>Cadastro de Usuários</q-toolbar-title>
        <botao-menu-right/>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs position="top" no-pane-border inverted>
      <!-- Tabs - notice slot="title" -->
      <q-tab default slot="title" name="tab-1" icon="folder shared" label="Cadastro"/>

      <!-- Targets -->
      <q-tab-pane name="tab-1">
        <q-page class="q-pa-sm full-height">

          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarUsuario">Novo</q-btn>
                <q-btn small type="submit" icon="save" v-if="!usuario.usuario && possoGravarUsuario" >Gravar</q-btn>
                <q-btn small type="submit" icon="save" v-if="usuario.usuario && possoAlterarUsuario" >Alterar</q-btn>
                <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirUsuario">Excluir</q-btn>
              </div>
              <div class="col-md-6 botoesDireita">
                <q-btn small type="button" icon="lock open" @click="ModalTrocaSenha = true" v-if="possoAlterarUsuario" >Alterar Senha</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <q-field
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.usuario.nome.$error"
                  :error-label="errorNome"
                  label="Nome"
                  orientation="vertical"
                >
                  <q-input autocomplete="off" type="text" v-model="usuario.nome" @blur="$v.usuario.nome.$touch()" required name="name"/>
                </q-field>

              </div>
              <div class="col-md-4">
                <q-field
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.usuario.login.$error"
                  :error-label="errorLogin"
                  label="Login"
                  orientation="vertical"
                >
                  <q-input autocomplete="off" type="text" v-model="usuario.login" @input="$v.usuario.login.$touch()" required name="username"/>
                </q-field>

              </div>
              <div class="col-md-4">
                <q-field
                  class="form-input"
                  helper="Obrigatório"
                  label="Grupos de Usuário"
                  orientation="vertical"
                >
                  <q-select
                    v-model="usuario.grupoUsuario"
                    :options="optionsGrupoUsuario"
                    required
                  />
                </q-field>

              </div>
            </div>
          </form>

          <botao-mobile
            :id="usuario.usuario"
            :possoGravar="possoGravarUsuario"
            :possoAlterar="possoAlterarUsuario"
            :possoExcluir="possoExcluirUsuario"
            @salvarAlterar="salvarAlterar"
            @excluir="excluir"
            @reset="reset"
          />
        </q-page>

      </q-tab-pane>

    </q-tabs>
    <lista-de-registros/>
    <q-modal :content-css="{minWidth: '50vw', minHeight: '50vh'}" v-model="ModalTrocaSenha" @close="cancelarModal" @hide="resetaModalSenha">
      <q-modal-layout
        header-style="min-height: 100px"
        content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}"
        footer-class="bg-primary some-class"
        footer-style="{fontSize: '24px', fontWeight: 'bold'}"
      >
        <q-toolbar class="primary">
          <q-btn flat @click="cancelarModal">
            <q-icon name="keyboard_arrow_left" />
          </q-btn>
          <div class="q-toolbar-title">
            Alterar Senha
          </div>
        </q-toolbar>
        <q-toolbar slot="footer">
          <div class="q-toolbar-title">
            <div class="row justify-center botoes">
              <q-btn color="positive" type="submit" form="formAlterarSenhaOutroUsuario">Alterar</q-btn>
              <q-btn type="reset" color="light" class="text-black" form="formAlterarSenhaOutroUsuario" @click="ModalTrocaSenha = false">Cancelar</q-btn>
            </div>
          </div>
        </q-toolbar>
        <div class="layout-padding">
          Digite e confirme a nova senha
          <form @submit.prevent="alterarSenhaOutroUsuario" id="formAlterarSenhaOutroUsuario">
            <q-field
              class="input form-input"
              helper="Obrigatório"
              :error="$v.modal.senhaNova.$error"
              error-label="Digite a nova senha"
              label="Nova senha"
              orientation="vertical"
            >
            <q-input autocomplete="off" type="password" v-model="modal.senhaNova" @blur="$v.modal.senhaNova.$touch()" required/>
            </q-field>

            <q-field
              class="input form-input"
              helper="Obrigatório"
              :error="$v.modal.confirmaSenha.$error"
              error-label="As senhas novas devem ser iguais"
              label="Repita a nova senha"
              orientation="vertical"
            >
            <q-input autocomplete="off" type="password" v-model="modal.confirmaSenha" @blur="$v.modal.confirmaSenha.$touch()" required/>
            </q-field>

          </form>

        </div>
      </q-modal-layout>
    </q-modal>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import BotaoMenuRight from 'src/components/header/BotaoMenuRight'
import ListaDeRegistros from 'src/components/menuRight/ListaUsuarios.vue'
import { required, minLength, sameAs } from 'vuelidate/lib/validators'
import Usuario from 'src/services/usuario/Usuario'
import usuarioService from 'src/services/usuario/UsuarioService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import botaoMobile from 'src/components/QFab/QFab'
import notify from '../../tools/Notify'
var timer

export default {
  name: 'Cadastro-de-Usuarios',
  components: {
    ListaDeRegistros,
    BotaoMenuLeft,
    BotaoMenuRight,
    botaoMobile
  },
  data () {
    return {
      modal: {
        senhaNova: '',
        confirmaSenha: ''
      },
      ModalTrocaSenha: false,
      selected: [],
      usuario: new Usuario(),
      grupoUsuario: '',
      optionsGrupoUsuario: [],
      errorNome: 'Preencha nome do usuário',
      errorLogin: 'Preencha o login do usuário',
      possoAlterarUsuario: false,
      possoExcluirUsuario: false
    }
  },
  validations: {
    usuario: {
      login: {
        required,
        isUnique (value) {
          let login = value
          // se for vazio, passo a bola pro validador required
          if (login === '') {
            this.errorLogin = 'Preencha o login do usuário'
            return true
          }
          let opcao = 'gravar'
          let id = ''
          if (this.usuario.usuario) {
            opcao = 'alterar'
            id = this.usuario.usuario
          }
          let retorno = confereRegistro('usuarios', 'login', opcao, id, 'usuario', login)
            .then(result => {
              if (result.status === 200) {
                if (result.data.resposta === true) {
                  return true
                } else {
                  this.errorLogin = 'Este login já está em uso, escolha um diferente'
                  return false
                }
              }
            })
          return retorno
        }
      },
      nome: {
        required
      },
      grupoUsuario: {
        required
      }
    },
    modal: {
      senhaNova: {
        required,
        minLength: minLength(5)
      },
      confirmaSenha: {
        sameAsPassword: sameAs('senhaNova')
      }
    }
  },
  methods: {
    resetaModalSenha () {
      this.$v.modal.$reset()
      this.modal.senhaNova = ''
      this.modal.confirmaSenha = ''
    },
    alterarSenhaOutroUsuario () {
      this.$v.modal.$touch()
      if (this.$v.modal.$error) {
        this.$q.dialog({
          title: 'Atenção',
          message: 'Alguns campos precisam ser corrigidos.'
        }).then(() => { }).catch(() => { })
      } else {
        this.$q.loading.show({
          message: 'Processando sua requisição',
          messageColor: 'white',
          spinnerSize: 250, // in pixels
          spinnerColor: 'white'
        })
        usuarioService.alteraSenhaOutroUsuario(this.usuario.usuario, this.modal.senhaNova, this.usuario.usuarioCriador)
          .then(result => {
            this.$q.loading.hide()
            this.ModalTrocaSenha = false
            this.$q.notify({
              type: 'positive',
              message: 'Senha Alterada com sucesso.',
              timeout: 5000
            })
          })
      }
    },
    cancelarModal () {
      this.modal.senhaNova = ''
      this.modal.confirmaSenha = ''
      this.$v.modal.$reset()
    },
    reset () {
      this.$v.usuario.$reset()
      this.usuario = new Usuario()
      this.possoAlterarUsuario = false
      this.possoExcluirUsuario = false
      this.$router.push({name: 'usuario'})
    },
    carrega (id) {
      console.log('vou carregar o usuario')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      usuarioService
        .seleciona(id)
        .then(result => {
          console.log(result)
          this.$q.loading.hide()
          console.log('peguei o usuario com sucesso')
          this.usuario = Object.assign({}, this.usuario, result.data)
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
        this.$v.usuario.$touch()
        if (this.$v.usuario.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.usuario.usuario && this.possoAlterarUsuario) {
          console.log('estou alterando o form')
          usuarioService.altera(this.usuario)
            .then(result => {
              console.log('usuario alterado com sucesso')
              this.$root.$emit('alteraUnicoRegistro', this.usuario)
              this.$q.notify({
                type: 'positive',
                message: 'Usuário alterado com sucesso.',
                timeout: 5000
              })
              this.$q.loading.hide()
            })
        } else if (!this.usuario.usuario && this.possoGravarUsuario) {
          usuarioService.grava(this.usuario)
            .then(result => {
              console.log('usuario criado com sucesso')
              this.usuario.usuario = result.data.usuario.usuario
              this.usuario.usuarioCriador = result.data.usuario.usuarioCriador
              this.$router.push('/usuarios/usuario/' + result.data.usuario.usuario)
              this.$q.notify({
                type: 'positive',
                message: 'Usuário criado com sucesso.',
                timeout: 5000
              })
              this.$q.notify({
                type: 'warning',
                message: 'Foi criado uma senha automática: 12345. Será necessário a troca da senha no primeiro login deste usuário.',
                timeout: 10000
              })
              this.$root.$emit('adicionaRegistroNaLista', this.usuario)
              this.confereAlterarExcluir()
              // this.$q.loading.hide() nao precisa, pois ele carrega o registro em seguida
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir () {
      if (this.possoExcluirUsuario) {
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

          usuarioService.apaga(this.usuario.usuario)
            .then(result => {
              this.$q.loading.hide()
              console.log('usuario removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'Usuário removido com sucesso.',
                timeout: 5000
              })
              this.$root.$emit('removeRegistro', this.usuario.usuario)
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
    setOptionsGrupoUsuario (grupoUsuario) {
      if (grupoUsuario.length > 0) {
        let optionsGrupoUsuario = []
        grupoUsuario.map(grupo => optionsGrupoUsuario.push(
          {
            label: grupo.descricao,
            value: grupo.grupoUsuario
          }
        ))
        this.optionsGrupoUsuario = optionsGrupoUsuario
      } else {
        this.optionsGrupoUsuario = [{
          label: 'Não existe grupo de usuário cadastrado',
          value: ''
        }]
      }
    },
    confereAlterarExcluir () {
      this.possoAlterarUsuario = permissoes.alterar('usuario')
      this.possoExcluirUsuario = permissoes.excluir('usuario')
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
      getPermissoes: 'login/getPermissoes',
      getUsuario: 'login/getUsuario'
    }),
    possoGravarUsuario: () => permissoes.gravar('usuario')
  },
  mounted () {
    usuarioService
      .getOptions()
      .then(result => this.setOptionsGrupoUsuario(result.data.grupoUsuarios))
  }
}
</script>
