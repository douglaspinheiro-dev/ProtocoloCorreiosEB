<template>
  <q-layout>
    <q-header class="desktop-only">
      <q-toolbar class="desktop-only">
          <q-toolbar-title class="text-center">
            <img :src="imageSrc" alt="">
            <span slot="subtitle">
              <div class="q-headline">
                SISPROT - SISTEMA DE PROTOCOLO DA 1ª REGIÃO MILITAR
              </div>
            </span>
          </q-toolbar-title>
        </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page>
        <!-- page content -->

        <div class="absolute-center" style="width: 500px; max-width: 90vw;">
          <h2 class="desktop-only text-center">Bem Vindo</h2>
          <form @submit.prevent="submit">
            <q-field label="Login" orientation="vertical">
              <q-input v-model="form.login" @input="$v.form.login.$touch()" autocomplete="username"/>
            </q-field>
            <br>
            <q-field label="Senha" orientation="vertical">
              <q-input v-model="form.password" type="password" @input="$v.form.password.$touch()" autocomplete="current-password"/>
            </q-field>
            <br>
              <div class="row justify-center botoes">
                <q-btn-group>
                  <q-btn type="submit" color="primary" glossy label="Entrar" />
                  <!-- <q-btn type="button" color="white" glossy label="Esqueci" class="text-black" @click="modalRecuperar = !modalRecuperar"/> -->
                </q-btn-group>
              </div>
          </form>

        </div>

        <q-dialog ref="modalRecuperar" minimized v-model="modalRecuperar" @hide="resetaStepper">
          <q-stepper ref="stepper">
            <!-- Step: -->
            <q-step default title="Identificação">
              <h6>Esqueceu a password?</h6>
              <p>Confirme seu usuário para receber um email<br>
              com seu código de confirmação.</p>
              <form @submit.prevent="enviarCodigoEmail">
                <q-input class="input" type="text" v-model="recuperarLogin.login" stack-label="Confirme seu usuário" @input="$v.recuperarLogin.login.$touch()"/>
                <q-stepper-navigation class="pull-right">
                  <q-btn color="primary" type="submit">Enviar</q-btn>
                </q-stepper-navigation>
              </form>

            </q-step>
            <!-- Step: -->
            <q-step title="Confirmação">
              <h6>Abra seu email.</h6>
              <p>Enviamos um código para o seu email, <br>
              confirme abaixo para resetar sua password</p>
              <form @submit.prevent="confirmarCodigo">
                <q-input class="input" type="text" v-model="confirmarToken.token" stack-label="Insira o código de confirmação" @input="$v.confirmarToken.token.$touch()"/>
                <q-stepper-navigation class="pull-right">
                  <q-btn color="primary" type="submit">Enviar</q-btn>
                </q-stepper-navigation>
              </form>
            </q-step>
            <!-- Step: -->
            <q-step title="Pronto">
              <h6>Confirmado!</h6>
              <p>Agora, vamos cadastrar sua nova password.</p>
              Digite e confirme a nova password
              <form @submit.prevent="alterarSenhaUsuario" id="formAlterarSenhaOutroCliente">
                <q-field
                  class="input"
                  helper="Obrigatório"
                  :error="$v.alterarSenha.passwordNova.$error"
                  error-label="Digite a nova password"
                  label="Nova password"
                >
                <q-input type="password" v-model="alterarSenha.passwordNova" @blur="$v.alterarSenha.passwordNova.$touch()" required autocomplete="new-password"/>
                </q-field>

                <q-field
                  class="input"
                  helper="Obrigatório"
                  :error="$v.alterarSenha.confirmaSenha.$error"
                  error-label="As passwords novas devem ser iguais"
                  label="Repita a nova password"
                >
                <q-input type="password" v-model="alterarSenha.confirmaSenha" @blur="$v.alterarSenha.confirmaSenha.$touch()" required autocomplete="new-password"/>
                </q-field>
                <q-stepper-navigation class="pull-right">
                  <q-btn color="primary" type="submit">Enviar</q-btn>
                </q-stepper-navigation>

              </form>

            </q-step>
            <!--
              Optional.
              "Globally" available Stepper navigation which means
              that it will be visible regardless of the current step.
              If we'd put QStepperNavigation under a QStep then we'd
              be using it for that step only.

            <q-stepper-navigation>
              <q-btn flat @click="$refs.stepper.previous()">Voltar</q-btn>
              <q-btn @click="$refs.stepper.next()" :disable="!recuperar.usuario ? true : false">Próximo</q-btn>
            </q-stepper-navigation>
            -->
          </q-stepper>
          <q-inner-loading :visible="loadingVisible">
            <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
          </q-inner-loading>
        </q-dialog>

        <q-dialog v-model="dialogValida">
          <span slot="title">Atenção</span>
          <span slot="message">Todos os campos são obrigatórios, e password mínima de 5 caracteres.</span>
          <template slot="buttons" slot-scope="props">
            <q-btn flat label="Ok"  @click="props.cancel"/>
          </template>
        </q-dialog>

        <q-dialog v-model="dialogLoginObrigatorio">
          <span slot="title">Atenção</span>
          <span slot="message">Campo Login é obrigatório</span>
          <template slot="buttons" slot-scope="props">
            <q-btn flat label="Ok"  @click="props.cancel"/>
          </template>
        </q-dialog>

        <q-dialog v-model="dialogConfirmarToken">
          <span slot="title">Atenção</span>
          <span slot="message">Insira o código recebido</span>
          <template slot="buttons" slot-scope="props">
            <q-btn flat label="Ok"  @click="props.cancel"/>
          </template>
        </q-dialog>

        <q-dialog v-model="dialogConfirmarSenha">
          <span slot="title">Atenção</span>
          <span slot="message">As passwords não podem ser vazias e devem ser iguais</span>
          <template slot="buttons" slot-scope="props">
            <q-btn flat label="Ok"  @click="props.cancel"/>
          </template>
        </q-dialog>

      </q-page>
    </q-page-container>
    <q-footer class="desktop-only">
      <q-toolbar >
        <q-toolbar-title class="text-center">
          Copyright &copy; 2019 - Exército Brasileiro - 1ª Região Militar.
          <span slot="subtitle">
            <div class="q-subheading">
              Desenvolvido por ST Moreira
            </div>
          </span>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>
  </q-layout>

</template>

<script>
import recuperarSenhaService from 'src/services/recuperarSenha/RecuperarSenhaService'
import loginService from 'src/services/login/LoginService'
import { required, minLength, sameAs } from 'vuelidate/lib/validators'
export default {
  name: 'Login',
  data () {
    return {
      imageSrc: 'statics/logo.png',
      confirmarToken: {
        token: ''
      },
      usuario: '',
      form: {
        login: '',
        password: ''
      },
      recuperarLogin: {
        login: ''
      },
      disableBotaoNext: true,
      alterarSenha: {
        usuario: '',
        passwordNova: '',
        confirmaSenha: ''
      },
      loadingVisible: false,
      loadingConfirmarToken: false,
      modalRecuperar: false,
      dialogValida: false,
      dialogLoginObrigatorio: false,
      dialogConfirmarToken: false,
      dialogConfirmarSenha: false
    }
  },
  validations: {
    form: {
      login: {
        required
      },
      password: {
        required,
        minLength: minLength(5)
      }
    },
    recuperarLogin: {
      login: {
        required
      }
    },
    confirmarToken: {
      token: {
        required
      }
    },
    alterarSenha: {
      passwordNova: {
        required,
        minLength: minLength(5)
      },
      confirmaSenha: {
        sameAsPassword: sameAs('passwordNova')
      }
    }
  },
  props: {
    nome: {},
    grupo: {}
  },
  computed: {
    // ...mapGetters(['isLogged', 'getSessaoInvalida'])

  },
  methods: {
    resetaStepper () {
      this.recuperarLogin.login = ''
      this.alterarSenha.usuario = ''
      this.alterarSenha.passwordNova = ''
      this.alterarSenha.confirmaSenha = ''
      this.confirmarToken.token = ''
      this.$refs.stepper.reset()
    },
    submit () {
      if (this.dialogValida) {
        this.dialogValida = false
        return
      }
      this.$v.form.$touch()
      if (this.$v.form.$error) {
        this.dialogValida = true
        // this.$q.dialog({
        //   title: 'Atenção',
        //   message: 'Todos os campos são obrigatórios, e password mínima de 5 caracteres.',
        //   preventClose: true
        // }).then(() => {
        //   // Picked "OK"
        // }).catch(() => {
        //   // Picked "Cancel" or dismissed
        // })
        return
      }
      this.$q.loading.show({
        message: 'Validando seus dados',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      loginService.logar(this.form)
        .then(result => {
          this.$q.loading.hide()
          console.log(result.data)
          if (result.status === 200) {
            // confirma token
            this.$store.commit('login/setToken', result.data.token)
            this.$store.commit('login/setLogin', { login: this.form.login, id: result.data.id, categoriaUsuario: result.data.categoriaUsuario })
            this.$store.commit('login/setSessaoInvalida', false)
            this.$store.commit('login/setAuth', result.data.token)
            this.$store.commit('login/setPermissoes', result.data.permissoes)
            result.data.primeiroLogin ? this.$router.push('/dashboard/primeiroacesso') : this.$router.push('/dashboard')
          } else {
            console.log('acesso negado')
            this.$q.dialog({
              title: 'Atenção',
              message: result.data.error
            }).then(() => {
              // Picked "OK"
            }).catch(() => {
              // Picked "Cancel" or dismissed
            })
          }
        })
    },
    enviarCodigoEmail () {
      if (this.dialogLoginObrigatorio) {
        this.dialogLoginObrigatorio = false
        return
      }
      this.$v.recuperarLogin.$touch()
      if (this.$v.recuperarLogin.$error) {
        this.dialogLoginObrigatorio = true
        return
      }
      this.loadingVisible = true
      recuperarSenhaService.enviarCodigoEmail({ login: this.recuperarLogin.login })
        .then(result => {
          this.loadingVisible = false
          if (result.data === 1) {
            console.log('Email enviado ao usuario.')
            this.$refs.stepper.next()
          } else {
            this.recuperarLogin.login = ''
            this.$q.dialog({
              title: 'Atenção',
              message: 'Login não encontrado.'
            }).then(() => {
              // Picked "OK"
            }).catch(() => {
              // Picked "Cancel" or dismissed
            })
          }
        })
    },
    confirmarCodigo () {
      if (this.dialogConfirmarToken) {
        this.dialogConfirmarToken = false
        return
      }
      this.$v.confirmarToken.$touch()
      if (this.$v.confirmarToken.$error) {
        this.dialogConfirmarToken = true
        return
      }
      this.loadingVisible = true
      recuperarSenhaService.confirmarToken({
        login: this.recuperarLogin.login,
        token: this.confirmarToken.token
      })
        .then(result => {
          this.loadingVisible = false
          if (result.data.result === 1) {
            console.log('Token confirmado.')
            this.alterarSenha.usuario = result.data.usuario
            this.$refs.stepper.next()
          } else {
            this.confirmarToken.token = ''
            this.$q.dialog({
              title: 'Atenção',
              message: 'Código digitado está incorreto.'
            }).then(() => {
              // Picked "OK"
            }).catch(() => {
              // Picked "Cancel" or dismissed
            })
          }
        })
    },
    confirmarTokenLogin () {
      this.$v.confirmarToken.$touch()
      if (this.$v.confirmarToken.$error) {
        this.$q.dialog({
          title: 'Atenção',
          message: 'O Código deve ser preenchido.'
        }).then(() => {
          // Picked "OK"
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
        return
      }
      this.loadingConfirmarToken = true
      recuperarSenhaService.confirmarTokenLogin({
        usuario: this.usuario,
        token: this.confirmarToken.token
      })
        .then(result => {
          this.loadingConfirmarToken = false
          if (result.data.result === 1) {
            console.log('Token confirmado.')
            this.$store.dispatch('setLinks', [])
            this.$router.push('/home/mineradoras')
          } else {
            this.confirmarToken.token = ''
            this.$q.dialog({
              title: 'Atenção',
              message: 'Código está incorreto.'
            }).then(() => {
              // Picked "OK"
            }).catch(() => {
              // Picked "Cancel" or dismissed
            })
          }
        })
    },
    alterarSenhaUsuario () {
      if (this.dialogConfirmarSenha) {
        this.dialogConfirmarSenha = false
        return
      }
      this.$v.alterarSenha.$touch()
      if (this.$v.alterarSenha.$error) {
        this.dialogConfirmarSenha = true
        return
      }
      this.loadingVisible = true
      recuperarSenhaService.alterarSenha({
        usuario: this.alterarSenha.usuario,
        password: this.alterarSenha.passwordNova,
        token: this.confirmarToken.token
      })
        .then(result => {
          this.loadingVisible = false

          this.$q.dialog({
            title: 'Perfeito!',
            message: 'Sua password foi alterada com sucesso, já pode efetuar o login.'
          }).then(() => {
            // Picked "OK"
            this.modalRecuperar = false
          }).catch(() => {
            // Picked "Cancel" or dismissed
            this.modalRecuperar = false
          })
        })
    }
  },
  mounted () {
    if (this.getSessaoInvalida) {
      this.$q.dialog({
        title: 'Atenção',
        message: 'Sua sessão ficou muito tempo inativa, é necessário logar novamente.'
      }).then(() => {
        // Picked "OK"
        this.modalRecuperar = false
      }).catch(() => {
        // Picked "Cancel" or dismissed
        this.modalRecuperar = false
      })
    }
  }
}
</script>
