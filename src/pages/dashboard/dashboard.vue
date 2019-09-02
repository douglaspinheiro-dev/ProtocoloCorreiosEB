<template>
  <div>
    <bodyTabs titulo="Consultas" :menuDireita="false">
      <template slot="tabHeader">
        <!-- Tabs - notice slot="title" -->
        <q-tab name="tab-1" icon="mail_outline" label="Correspondências" v-if="getPermissoes.correspondencia.abrir"/>
        <q-tab name="tab-2" icon="fas fa-file-alt" label="Entradas" v-if="getPermissoes.protocoloEntrada.abrir"/>
        <q-tab name="tab-3" icon="move_to_inbox" label="Malotes" v-if="getPermissoes.malote.abrir"/>
      </template>

      <template slot="tabPanel">
        <!-- Targets -->
        <q-tab-panel name="tab-1" v-if="getPermissoes.correspondencia.abrir">
          <consulta-correspondencia></consulta-correspondencia>
        </q-tab-panel>
        <q-tab-panel name="tab-2" v-if="getPermissoes.protocoloEntrada.abrir">
          <consulta-protocolo-entrada></consulta-protocolo-entrada>
        </q-tab-panel>
        <q-tab-panel name="tab-3" v-if="getPermissoes.malote.abrir">
          <consulta-malote></consulta-malote>
        </q-tab-panel>

      </template>
    </bodyTabs>
    <q-dialog
      maximized
      v-model="modalPrimeiroAcesso"
    >
      <form @submit.prevent="submit">
        <q-dialog v-model="modalPrimeiroAcesso">
          <q-card>
            <q-card-section>
              <div class="text-h6">Alterar Senha</div>
            </q-card-section>

            <q-card-section>
              No primeiro acesso, é necessário criar uma nova senha.

              Digite a nova senha
              <div class="row">
                <div class="col-12 input">
                  <q-input
                    hint="Obrigatório"
                    :error="$v.form.senhaNova.$error"
                    error-message="Digite a nova senha, minimo de 5 caracteres"
                    type="password"
                    v-model="form.senhaNova"
                    stack-label
                    label="Nova senha"
                    @blur="$v.form.senhaNova.$touch()"
                    autocomplete="new-passoword"
                  />

                </div>
                <div class="col-12 input">
                  <q-input
                    hint="Obrigatório"
                    :error="$v.form.confirmaSenha.$error"
                    error-message="As senhas novas devem ser iguais"
                    type="password"
                    v-model="form.confirmaSenha"
                    stack-label
                    label="Repita a nova senha"
                    @blur="$v.form.confirmaSenha.$touch()"
                    autocomplete="new-passoword"
                  />
                </div>
              </div>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn
                color="positive"
                :disable="loadingVisible"
                type="submit"
              >Alterar</q-btn>
            </q-card-actions>
          </q-card>
        </q-dialog>

      </form>
    </q-dialog>
    <!-- <lista-de-registros /> -->
  </div>

</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'

import { mapGetters } from 'vuex'
import {
  required,
  sameAs,
  minLength
} from 'vuelidate/lib/validators'
import usuarioService from 'src/pages/sistema/usuario/UsuarioService'
import consultaCorrespondencia from 'src/pages/cadastro/correspondencia/BuscaCorrespondencia.vue'
import consultaMalote from 'src/pages/cadastro/malote/BuscaMalote.vue'
import consultaProtocoloEntrada from 'src/pages/cadastro/protocoloEntrada/BuscaProtocoloEntrada.vue'
export default {
  name: 'Dashboard',
  components: {
    BodyTabs,
    consultaCorrespondencia,
    consultaMalote,
    consultaProtocoloEntrada
  },
  data () {
    return {
      tab: 'tab-1',
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
