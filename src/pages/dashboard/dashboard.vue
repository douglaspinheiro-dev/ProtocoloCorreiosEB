<template>
  <div>
    <q-layout-header>
      <q-toolbar>
        <botao-menu-left />
        <q-toolbar-title>Consultas</q-toolbar-title>
      </q-toolbar>

    </q-layout-header>
    <!-- content -->
    <q-tabs
      position="top"
      no-pane-border
      inverted
    >
      <!-- Tabs - notice slot="title" -->
      <q-tab
        slot="title"
        name="correspondencia"
        icon="mail_outline"
        label="Correspondências"
        v-if="getPermissoes.correspondencia.abrir"
      />
      <q-tab
        slot="title"
        name="protocoloEntrada"
        icon="fas fa-file-alt"
        label="Entradas"
        v-if="getPermissoes.protocoloEntrada.abrir"
      />
      <q-tab
        slot="title"
        name="malote"
        icon="move_to_inbox"
        label="Malotes"
        v-if="getPermissoes.malote.abrir"
      />

      <!-- Targets -->
      <q-tab-pane
        name="correspondencia"
        v-if="getPermissoes.correspondencia.abrir"
      >
        <consulta-correspondencia></consulta-correspondencia>
      </q-tab-pane>

      <q-tab-pane
        name="protocoloEntrada"
        v-if="getPermissoes.protocoloEntrada.abrir"
      >
        <consulta-protocolo-entrada></consulta-protocolo-entrada>
      </q-tab-pane>

      <q-tab-pane
        name="malote"
        v-if="getPermissoes.malote.abrir"
      >
        <consulta-malote></consulta-malote>
      </q-tab-pane>

    </q-tabs>
    <q-modal
      maximized
      v-model="modalPrimeiroAcesso"
    >
      <form @submit.prevent="submit">

        <q-modal-layout
          header-style="min-height: 100px"
          content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}"
          footer-class="bg-primary some-class"
          footer-style="{fontSize: '24px', fontWeight: 'bold'}"
        >
          <q-toolbar class="primary">
            <div class="center q-toolbar-title">
              Alterar Senha
            </div>
          </q-toolbar>
          <q-toolbar slot="footer">
            <div class="q-toolbar-title">
              <div class="row justify-center botoes">
                <q-btn
                  color="positive"
                  :disable="loadingVisible"
                  type="submit"
                >Alterar</q-btn>
              </div>
            </div>
          </q-toolbar>
          <div class="layout-padding">
            <p class="q-title">Bem vindo</p>
            <p class="q-subheading">No primeiro acesso, é necessário criar uma nova senha.</p>

            Digite a nova senha
            <div class="row">
              <div class="col-12 input">
                <q-field
                  helper="Obrigatório"
                  :error="$v.form.senhaNova.$error"
                  error-label="Digite a nova senha, minimo de 5 caracteres"
                >
                  <q-input
                    type="password"
                    v-model="form.senhaNova"
                    stack-label="Nova senha"
                    @blur="$v.form.senhaNova.$touch()"
                    autocomplete="new-passoword"
                  />
                </q-field>

              </div>
              <div class="col-12 input">
                <q-field
                  helper="Obrigatório"
                  :error="$v.form.confirmaSenha.$error"
                  error-label="As senhas novas devem ser iguais"
                >
                  <q-input
                    type="password"
                    v-model="form.confirmaSenha"
                    stack-label="Repita a nova senha"
                    @blur="$v.form.confirmaSenha.$touch()"
                    autocomplete="new-passoword"
                  />
                </q-field>
              </div>
            </div>
          </div>
        </q-modal-layout>
      </form>
    </q-modal>
  </div>

</template>

<script>
import BotaoMenuLeft from 'src/components/header/BotaoMenuLeft'
import { mapGetters } from 'vuex'
import {
  required,
  sameAs,
  minLength
} from 'vuelidate/lib/validators'
import usuarioService from 'src/services/usuario/UsuarioService'
import consultaCorrespondencia from 'src/components/BuscaCorrespondencia'
import consultaMalote from 'src/components/BuscaMalote'
import consultaProtocoloEntrada from 'src/components/BuscaProtocoloEntrada'
export default {
  name: 'Dashboard',
  components: {
    BotaoMenuLeft,
    consultaCorrespondencia,
    consultaMalote,
    consultaProtocoloEntrada
  },
  data () {
    return {
      modalPrimeiroAcesso: false,
      loadingVisible: false,
      form: {
        senhaNova: '',
        confirmaSenha: ''
      }
    }
  },
  validations: {
    form: {
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
    cancelarModal () {
      this.form.senhaNova = ''
      this.form.confirmaSenha = ''
      this.$v.form.$reset()
      this.loadingVisible = false
      this.modalPrimeiroAcesso = false
    },
    submit () {
      this.$v.form.$touch()
      if (this.$v.form.$error) {
        this.$q.dialog({
          title: 'Atenção',
          message: 'Todos os campos são obrigatórios, e senha mínima de 5 caracteres.',
          buttons: [
            'OK'
          ]
        })
      } else {
        this.$q.loading.show({
          message: 'Processando sua requisição',
          messageColor: 'white',
          spinnerSize: 250, // in pixels
          spinnerColor: 'white'
        })
        usuarioService.alteraSenha('12345', this.form.senhaNova)
          .then(result => {
            this.$q.loading.hide()
            if (result.status === 202) {
              this.$q.notify({
                type: 'positive',
                message: 'Senha Alterada com sucesso.',
                timeout: 5000
              })
              this.cancelarModal()
            }
          })
      }
    }
  },
  computed: {
    ...mapGetters({
      getLogin: 'login/getLogin',
      getUserId: 'login/getUserId',
      getPermissoes: 'login/getPermissoes'
    })
  },
  props: {
    primeiroLogin: {}
  },
  mounted () {
    if (this.primeiroLogin) {
      this.modalPrimeiroAcesso = true
    }
  }
}
</script>
<style scoped>
.input {
  margin-top: 20px;
}
</style>
