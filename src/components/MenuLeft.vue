<template>
  <q-drawer side="left" elevated v-model="mostraMenuLeft" behavior="mobile" :width="360">
    <q-scroll-area class="fit">
      <q-list bordered class="rounded-borders menuLeft">
        <q-expansion-item group="menuSuperior" icon="perm_identity" :label="getLogin">
          <q-item clickable v-ripple link @click.native="abreModalTrocaSenha = !abreModalTrocaSenha">
            <q-item-section>Alterar Senha</q-item-section>
          </q-item>

          <q-item clickable v-ripple link @click.native="logout">
            <q-item-section>Sair</q-item-section>
          </q-item>
        </q-expansion-item>

        <q-separator />
        <q-item-label header>Menu de Navegação</q-item-label>

        <q-item v-ripple link :to="{name: 'dashboard'}">
          <q-item-section avatar>
            <q-icon color="primary" name="dashboard" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Consultas</q-item-label>
            <q-item-label caption>Procurar documentos, imprimir Relatórios</q-item-label>
          </q-item-section>
        </q-item>

        <q-expansion-item group="menuLinks" icon="settings" label="Sistema" v-if="hasSistema">
          <q-item v-for="(link, index) in linksSistema" :key="index" v-ripple link :to="{name: link.rota}">
            <q-item-section>
              <q-item-label>{{link.titulo}}</q-item-label>
              <q-item-label v-if="link.subtitulo !== ''" caption>{{link.subTitulo}}</q-item-label>
            </q-item-section>
            <q-item-section v-if="link.icone !== ''" side top>
              <q-icon :color="link.corIcone" :name="link.icone" />
            </q-item-section>
          </q-item>
        </q-expansion-item>

        <q-expansion-item group="menuLinks" icon="folder_shared" label="Cadastro" v-if="hasCadastro">
          <q-item v-for="(link, index) in linksCadastro" :key="index" v-ripple link :to="{name: link.rota}">
            <q-item-section>
              <q-item-label>{{link.titulo}}</q-item-label>
              <q-item-label v-if="link.subtitulo !== ''" caption>{{link.subTitulo}}</q-item-label>
            </q-item-section>
            <q-item-section v-if="link.icone !== ''" side top>
              <q-icon :color="link.corIcone" :name="link.icone" />
            </q-item-section>
          </q-item>

        </q-expansion-item>

          <!-- <q-item v-ripple link :to="{name: 'scanner'}">
            <q-item-section>
              <q-item-label>Escanear Doc</q-item-label>
              <q-item-label caption>Escanear com webcam para pdf</q-item-label>
            </q-item-section>
            <q-item-section side top>
              <q-icon color="primary" name="print" />
            </q-item-section>
          </q-item> -->
      </q-list>
    </q-scroll-area>

    <q-dialog :content-css="{minWidth: '50vw', minHeight: '50vh'}" v-model="abreModalTrocaSenha">
      <q-card>
        <q-card-section class="row items-center">
          <div class="text-h6">Alterar Senha</div>
          <q-btn icon="close" flat round dense v-close-dialog @click="cancelarModal" :disable="loadingVisible" />
        </q-card-section>

        <q-card-section>
          <div class="layout-padding">
            Digite a senha atual e a nova senha
            <form @submit.prevent="submit" id="formAlterarSenha">
              <q-input hint="Obrigatório" :error="$v.form.senhaAtual.$error" error-message="Digite a senha atual" type="password"
                v-model="form.senhaAtual" stack-label label="Senha atual" @blur="$v.form.senhaAtual.$touch()"
                autocomplete="current-password" />

              <q-input hint="Obrigatório" :error="$v.form.senhaNova.$error" error-message="Digite a nova senha, minimo de 5 caracteres"
                type="password" v-model="form.senhaNova" stack-label label="Nova senha" @blur="$v.form.senhaNova.$touch()"
                autocomplete="new-passoword" />

              <q-input hint="Obrigatório" :error="$v.form.confirmaSenha.$error" error-message="As senhas novas devem ser iguais"
                type="password" v-model="form.confirmaSenha" stack-label label="Repita a nova senha" @blur="$v.form.confirmaSenha.$touch()"
                autocomplete="new-passoword" />

            </form>

          </div>
          <br>
          <div class="row justify-center botoes">
            <q-btn color="primary" :disable="loadingVisible" type="submit" form="formAlterarSenha">Alterar</q-btn>
            <q-btn type="reset" :disable="loadingVisible" color="light" class="text-black" form="formAlterarSenha"
              @click="cancelarModal">Cancelar</q-btn>
          </div>
        </q-card-section>
        <q-inner-loading :showing="loadingVisible">
          <q-spinner size="50px" color="primary"></q-spinner>
        </q-inner-loading>
      </q-card>
    </q-dialog>
  </q-drawer>
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
import usuarioService from 'src/pages/sistema/usuario/UsuarioService'

export default {
  name: 'MenuLeft',
  components: {},
  props: ['quasar'],
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
      this.abreModalTrocaEmpresa = false
    }
  },
  created () {
    this.$root.$on('toggleLeft', () => {
      this.mostraMenuLeft = !this.mostraMenuLeft
    })

    this.$root.$on('controlaMenuLeft', (valor) => {
      this.mostraMenuLeft = valor
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
    }),
    hasSistema: function () {
      for (const key in this.getPermissoes) {
        if (this.getPermissoes[key].categoriaModulo === 'SISTEMA' && this.getPermissoes[key].abrir) {
          return true
        }
      }
      return false
    },
    hasCadastro: function () {
      for (const key in this.getPermissoes) {
        if (this.getPermissoes[key].categoriaModulo === 'CADASTROS' && this.getPermissoes[key].abrir) {
          return true
        }
      }
      return false
    },
    linksSistema: function () {
      const links = [
      // {
      //   rota: 'configuracaoSistema',
      //   titulo: 'Configuração do Sistema',
      //   subTitulo: 'Define configurações gerais para o sistema',
      //   icone: 'settings',
      //   corIcone: 'primary'
      // },
        {
          rota: 'grupoUsuario',
          titulo: 'Grupos de Usuários',
          subTitulo: 'Organiza por grupo e cria permissões',
          icone: 'supervisor_account',
          corIcone: 'primary'
        },
        {
          rota: 'usuario',
          titulo: 'Usuários',
          subTitulo: 'Cadastra usuários do sistema e gerencia acessos às empresas',
          icone: 'person',
          corIcone: 'primary'
        }
      ]

      return links.filter((link) => this.getPermissoes[link.rota].abrir)
    },
    linksCadastro: function () {
      const links = [
        { rota: 'tipoDocumento', titulo: 'Tipos de Documentos', icone: 'fas fa-file-contract', corIcone: 'primary' },
        { rota: 'tipoCorrespondencia', titulo: 'Tipos de Correspondencias', icone: 'fas fa-envelope', corIcone: 'primary' },
        { rota: 'tipoCobranca', titulo: 'Tipos de Cobranças', icone: 'attach_money', corIcone: 'primary' },
        { rota: 'endereco', titulo: 'Endereços', icone: 'fas fa-map-marked-alt', corIcone: 'primary' },
        { rota: 'setor', titulo: 'Setores Internos', icone: 'work_outline', corIcone: 'primary' },
        { rota: 'protocoloEntrada', titulo: 'Protocolo de Entrada', icone: 'fas fa-file-alt', corIcone: 'primary' },
        { rota: 'rota', titulo: 'Rotas', icone: 'fas fa-map-marked-alt', corIcone: 'primary' },
        { rota: 'malote', titulo: 'Malotes', icone: 'move_to_inbox', corIcone: 'primary' },
        { rota: 'correspondencia', titulo: 'Correspondencias', icone: 'mail_outline', corIcone: 'primary' }
        // {
        //   rota: 'membro',
        //   titulo: 'Membros',
        //   icone: 'fas fa-id-card',
        //   corIcone: 'primary'
        // },
        // {
        //   rota: 'igreja',
        //   titulo: 'Igrejas',
        //   icone: 'home',
        //   corIcone: 'primary'
        // }
      ]

      return links.filter((link) => this.getPermissoes[link.rota].abrir)
    }
  }
}

</script>

<style scoped>
  h3 {
    margin: 10px;
  }

  .menuLeft{
    margin-bottom: 50px;
  }

</style>
