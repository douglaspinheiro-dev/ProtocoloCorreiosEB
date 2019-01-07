<template>
  <q-layout-drawer v-model="mostraMenuLeft" side="left" behavior="mobile">
    <!--
      Use <q-side-link> component
      instead of <q-item> for
      internal vue-router navigation
    -->

    <q-list no-border link inset-delimiter sparse>
      <q-collapsible group="menuSuperior" icon="perm_identity" :label="getLogin">
        <q-item link @click.native="abreModalTrocaSenha = !abreModalTrocaSenha">
          <q-item-side icon="lock outline" />
          <q-item-main label="Alterar Senha" />
        </q-item>

      </q-collapsible>
      <q-item link @click.native="logout">
        <q-item-side icon="exit to app" />
        <q-item-main label="Sair" sublabel="Sair do sistema" />
      </q-item>

      <q-item-separator />
      <q-list-header>Menu de Navegação</q-list-header>

      <q-side-link v-for="(link, key) in links" :key="key" item :to="link.to" exact>
        <q-item-side :icon="link.icon" />
        <q-item-main :label="link.label" :sublabel="link.sublabel" />
      </q-side-link>

        <q-item link :to="{name: 'dashboard'}">
          <q-item-side icon="dashboard" />
          <q-item-main label="Dashboard" sublabel="Graficos, estatisticas" />
        </q-item>

        <q-collapsible group="menuLinks" icon="settings" label="Sistema">

        <q-item link :to="{name: 'grupoUsuario'}" v-if="getPermissoes.grupoUsuario.abrir">
          <q-item-side icon="supervisor account" />
          <q-item-main label="Grupo de Usuários" sublabel="Organiza por grupo e cria permissões" />
        </q-item>
        <q-item link :to="{name: 'usuario'}" v-if="getPermissoes.usuario.abrir">
          <q-item-side icon="person" />
          <q-item-main label="Usuários" sublabel="Cadastra usuários do sistema" />
        </q-item>

      </q-collapsible>

      <q-collapsible group="menuLinks" icon="folder shared" label="Cadastro">

        <q-item link :to="{name: 'tipoDocumento'}" v-if="getPermissoes.tipoDocumento.abrir">
          <q-item-side icon="fas fa-file-contract" />
          <q-item-main label="Tipos de Documentos" />
        </q-item>

        <q-item link :to="{name: 'tipoCorrespondencia'}" v-if="getPermissoes.tipoCorrespondencia.abrir">
          <q-item-side icon="fas fa-envelope" />
          <q-item-main label="Tipos de Correspondencias" />
        </q-item>

        <q-item link :to="{name: 'tipoCobranca'}" v-if="getPermissoes.tipoCobranca.abrir">
          <q-item-side icon="attach_money" />
          <q-item-main label="Tipos de Cobrancas" />
        </q-item>

        <q-item link :to="{name: 'endereco'}" v-if="getPermissoes.endereco.abrir">
          <q-item-side icon="fas fa-map-marked-alt" />
          <q-item-main label="Endereços" />
        </q-item>

        <q-item link :to="{name: 'setor'}" v-if="getPermissoes.setor.abrir">
          <q-item-side icon="work_outline" />
          <q-item-main label="Setores Internos" />
        </q-item>

        <q-item link :to="{name: 'protocoloEntrada'}" v-if="getPermissoes.protocoloEntrada.abrir">
          <q-item-side icon="fas fa-file-alt" />
          <q-item-main label="Protocolo de Entrada" />
        </q-item>

        <q-item link :to="{name: 'rota'}" v-if="getPermissoes.rota.abrir">
          <q-item-side icon="fas fa-map-marked-alt" />
          <q-item-main label="Rotas" />
        </q-item>

        <q-item link :to="{name: 'malote'}" v-if="getPermissoes.malote.abrir">
          <q-item-side icon="move_to_inbox" />
          <q-item-main label="Malotes" />
        </q-item>

        <q-item link :to="{name: 'correspondencia'}" v-if="getPermissoes.correspondencia.abrir">
          <q-item-side icon="mail_outline" />
          <q-item-main label="Correspondencias" />
        </q-item>

      </q-collapsible>

    </q-list>

    <q-modal :content-css="{minWidth: '50vw', minHeight: '50vh'}" v-model="abreModalTrocaSenha">
      <q-modal-layout header-style="min-height: 100px" content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}" footer-class="bg-primary some-class"
        footer-style="{fontSize: '24px', fontWeight: 'bold'}">
        <q-toolbar class="primary">
          <q-btn flat @click="cancelarModal" :disable="loadingVisible">
            <q-icon name="keyboard_arrow_left" />
          </q-btn>
          <div class="q-toolbar-title">
            Alterar Senha
          </div>
        </q-toolbar>
        <q-toolbar slot="footer">
          <div class="q-toolbar-title">
            <div class="row justify-center botoes">
              <q-btn color="positive" :disable="loadingVisible" type="submit" form="formAlterarSenha">Alterar</q-btn>
              <q-btn type="reset" :disable="loadingVisible" color="light" class="text-black" form="formAlterarSenha" @click="cancelarModal">Cancelar</q-btn>
            </div>
          </div>
        </q-toolbar>
        <div class="layout-padding">
          Digite a senha atual e a nova senha
          <form @submit.prevent="submit" id="formAlterarSenha">
            <q-field class="input" helper="Obrigatório" :error="$v.form.senhaAtual.$error" error-label="Digite a senha atual">
              <q-input type="password" v-model="form.senhaAtual" stack-label="Senha atual" @blur="$v.form.senhaAtual.$touch()" autocomplete="current-password"
              />
            </q-field>

            <q-field class="input" helper="Obrigatório" :error="$v.form.senhaNova.$error" error-label="Digite a nova senha, minimo de 5 caracteres">
              <q-input type="password" v-model="form.senhaNova" stack-label="Nova senha" @blur="$v.form.senhaNova.$touch()" autocomplete="new-passoword"
              />
            </q-field>

            <q-field class="input" helper="Obrigatório" :error="$v.form.confirmaSenha.$error" error-label="As senhas novas devem ser iguais">
              <q-input type="password" v-model="form.confirmaSenha" stack-label="Repita a nova senha" @blur="$v.form.confirmaSenha.$touch()"
                autocomplete="new-passoword" />
            </q-field>

          </form>

        </div>
      </q-modal-layout>
      <q-inner-loading :visible="loadingVisible">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading>
    </q-modal>

  </q-layout-drawer>
</template>

<script>
import {
  mapGetters
} from 'vuex'
import {
  required,
  sameAs,
  minLength
} from 'vuelidate/lib/validators'
import usuarioService from 'src/services/usuario/UsuarioService'
// import loginService from 'src/services/login/LoginService'

export default {
  name: 'MenuLeft',
  components: {},
  data () {
    return {
      mostraMenuLeft: false,
      abreModalTrocaSenha: false,
      abreModalTrocaEmpresa: false,
      form: {
        senhaAtual: '',
        senhaNova: '',
        confirmaSenha: ''
      },
      links: [],
      loadingVisible: false,
      trocaEmpresa: '',
      optionsEmpresa: []
    }
  },
  validations: {
    form: {
      senhaAtual: {
        required,
        minLength: minLength(5)
      },
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
    logout () {
      this.$store.commit('login/removeToken', '')
      this.$store.commit('login/setLogin', '')
      this.$store.commit('login/setSessaoInvalida', false)
      this.$router.push('/')
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
        this.loadingVisible = true
        usuarioService.alteraSenha(this.form.senhaAtual, this.form.senhaNova, this.getGrupoLogin)
          .then(result => {
            this.loadingVisible = false
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
    },
    cancelarModal () {
      this.form.senhaAtual = ''
      this.form.senhaNova = ''
      this.form.confirmaSenha = ''
      this.$v.form.$reset()
      this.loadingVisible = false
      this.abreModalTrocaSenha = false
    }

  },
  created () {
    this.$root.$on('toggleLeft', () => {
      this.mostraMenuLeft = !this.mostraMenuLeft
    })
  },
  mounted () {
    this.links = this.getLinks
    this.$q.platform.is.mobile ? this.mostraMenuLeft = false : this.mostraMenuLeft = true
  },
  computed: {
    ...mapGetters({
      getLogin: 'login/getLogin',
      getPermissoes: 'login/getPermissoes'
      // getGrupoLogin: 'getGrupoLogin'
    })
  }
}

</script>

<style scoped>
  h3 {
    margin: 10px
  }

</style>
