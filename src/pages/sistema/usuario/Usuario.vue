<template>
  <div>
    <bodyTabs titulo="Cadastro de Usuários">
      <template slot="tabHeader">
        <!-- Tabs - notice slot="title" -->
        <q-tab name="tab-1" icon="folder_shared" label="Cadastro" />
      </template>

      <template slot="tabPanel">
        <!-- Targets -->
        <q-tab-panel name="tab-1">

          <form @submit.prevent="salvarAlterar">
            <div class="row">
              <div class="col-md-6">

                <barra-de-botoes
                  @reset="reset"
                  @excluir="excluir"
                  @submit="salvarAlterar"
                  :id="usuario.usuario"
                  :possoGravar="possoGravarUsuario"
                  :possoAlterar="possoAlterarUsuario"
                  :possoExcluir="possoExcluirUsuario"
                />
              </div>
              <div class="col-md-6 text-right">
                <q-btn small type="button" icon="lock_open" @click="ModalTrocaSenha = true" v-if="possoAlterarUsuario" >Alterar Senha</q-btn>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <q-input class="form-input"
                  helper="Obrigatório"
                  :error="$v.usuario.nome.$error"
                  :error-label="errorNome"
                  label="Nome"
                  autocomplete="off" type="text" v-model="usuario.nome" @blur="$v.usuario.nome.$touch()" required name="name"/>
              </div>
              <div class="col-md-4">
                <q-input
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.usuario.login.$error"
                  :error-label="errorLogin"
                  label="Login"
                  autocomplete="off" type="text" v-model="usuario.login" @input="$v.usuario.login.$touch()" required name="username"/>
              </div>
              <div class="col-md-4">
                <form-select
                  classe="form-input"
                  label="Grupos de Usuário"
                  hint="Obrigatório"
                  v-model="usuario.grupoUsuario"
                  :options="optionsGrupoUsuario"
                  required
                />
              </div>
            </div>
          </form>

        </q-tab-panel>

      </template>
    </bodyTabs>
    <lista-de-registros />

    <q-dialog :content-css="{minWidth: '50vw', minHeight: '50vh'}" v-model="ModalTrocaSenha" @close="cancelarModal"
      @hide="resetaModalSenha">
      <q-card>
        <q-card-section class="row items-center">
          <div class="text-h6">Alterar Senha</div>
          <q-btn icon="close" flat round dense v-close-popup @click="cancelarModal"/>
        </q-card-section>

        <q-card-section>
          <div class="layout-padding">
            Digite e confirme a nova senha
            <form @submit.prevent="alterarSenhaOutroUsuario" id="alterarSenha">
              <q-input hint="Obrigatório" :error="$v.modal.senhaNova.$error" error-message="Digite a nova senha, minimo de 5 caracteres"
                type="password" v-model="modal.senhaNova" stack-label label="Nova senha" @blur="$v.modal.senhaNova.$touch()"
                />

              <q-input hint="Obrigatório" :error="$v.modal.confirmaSenha.$error" error-message="As senhas novas devem ser iguais"
                type="password" v-model="modal.confirmaSenha" stack-label label="Repita a nova senha" @blur="$v.modal.confirmaSenha.$touch()"
                />

            </form>

          </div>
          <br>
          <div class="row justify-center botoes">
            <q-btn color="primary" type="submit" form="alterarSenha">Alterar</q-btn>
            <q-btn type="reset" color="light" class="text-black" form="alterarSenha"
              @click="cancelarModal">Cancelar</q-btn>
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>

  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import BarraDeBotoes from 'src/components/form/BarraDeBotoes'
import { mapGetters } from 'vuex'
import ListaDeRegistros from './ListaUsuarios.vue'
import { required, minLength, sameAs } from 'vuelidate/lib/validators'
import Usuario from './Usuario'
import usuarioService from './UsuarioService'
import confereRegistro from 'src/services/confereRegistro'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import formSelect from 'src/components/form/select/QSelect'
var timer

export default {
  name: 'Cadastro-de-Usuarios',
  components: {
    BodyTabs,
    ListaDeRegistros,
    BarraDeBotoes,
    formSelect
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
