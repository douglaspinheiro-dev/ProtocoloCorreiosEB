<template>
  <div>
    <form @submit.prevent="salvarAlterar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarMaloteDocumento">Novo</q-btn>
          <q-btn small type="submit" icon="save" v-if="!maloteDocumento.maloteDocumento && possoGravarMaloteDocumento">Gravar</q-btn>
          <q-btn small type="submit" icon="save" v-if="maloteDocumento.maloteDocumento && possoAlterarMaloteDocumento">Alterar</q-btn>
          <q-btn small type="button" icon="delete" @click="excluir" v-if="maloteDocumento.maloteDocumento && possoExcluirMaloteDocumento">Excluir</q-btn>
        </div>
      </div>
      <q-list>
        <div class="row">
          <div class="col-md-3">
            <form-select
              classe="form-input"
              label="Tipo do Documento"
              hint="Obrigatório"
              required
              :error="$v.maloteDocumento.tipoDocumento.$error"
              error-message="Obrigatório"
              v-model="maloteDocumento.tipoDocumento"
              :options="optionsTipoDocumento"
              @input="$v.maloteDocumento.tipoDocumento.$touch()"
            />
            <q-linear-progress indeterminate v-show="optionsLoading"/>
          </div>

          <div class="col-md-9">
            <q-input label="Número"
              class="form-input"
              hint="Obrigatório"
              :error="$v.maloteDocumento.numero.$error"
              error-message="Obrigatório" type="tel" v-model="maloteDocumento.numero" @input="$v.maloteDocumento.numero.$touch()" name="numero"/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <form-select
              classe="form-input"
              label="Origem"
              hint="Obrigatório"
              required
              :error="$v.maloteDocumento.setor.$error"
              error-message="Obrigatório"
              v-model="maloteDocumento.setor"
              :options="optionsSetor"
              @input="$v.maloteDocumento.setor.$touch()"
            />
            <q-linear-progress indeterminate v-show="optionsLoading"/>
          </div>

          <div class="col-md-6">
            <form-select
              classe="form-input"
              label="Destino"
              hint="Obrigatório"
              required
              :error="$v.maloteDocumento.rotaEndereco.$error"
              error-message="Obrigatório"
              v-model="maloteDocumento.rotaEndereco"
              :options="optionsRotaEndereco"
              @input="$v.maloteDocumento.rotaEndereco.$touch()"
            />
            <q-linear-progress indeterminate v-show="optionsLoading"/>
          </div>
        </div>
      </q-list>
    </form>
    <br>
      <q-table title="Lista de MaloteDocumentos"
        :data="listaDeMaloteDocumentos"
        :columns="tabelaColunas"
        row-key="id"
        :loading="carregandoLista"
        :filter="buscaMaloteDocumento"
        :separator="tabelaSeparador"
        no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados"
        rows-per-page-label="Linhas por página"
        loading-label="Carregando"
      >

        <template slot="top-right" slot-scope="props">
          <q-btn
            flat round dense
            :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen"
          />
        </template>
        <q-td slot="body-cell-editar" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round icon="edit" @click="carrega(props.row.id)" />
        </q-td>
      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import MaloteDocumento from './MaloteDocumento'
import maloteDocumentoService from './MaloteDocumentoService'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Setor from 'src/pages/cadastro/setor/Setor'
import RotaEndereco from 'src/pages/cadastro/rota/RotaEndereco'
import formSelect from 'src/components/form/select/QSelect'

export default {
  name: 'MaloteDocumento',
  components: {formSelect},
  directives: {
    mask
  },
  data () {
    return {
      tipoDocumento: new TipoDocumento(),
      setor: new Setor(),
      rotaEndereco: new RotaEndereco(),
      buscaMaloteDocumento: '',
      optionsLoading: false,
      optionsTipoDocumento: [],
      optionsSetor: [],
      optionsRotaEndereco: [],
      maloteDocumento: new MaloteDocumento(),
      botaoSalvarAlterar: 'Salvar',
      carregandoLista: false,
      listaDeMaloteDocumentos: [],
      tabelaSeparador: 'horizontal',
      tabelaColunas: [
        {
          name: 'tipoDocumento',
          required: true,
          label: 'Documento',
          align: 'left',
          field: 'tipoDocumento',
          sortable: true
        },
        {
          name: 'numero',
          required: true,
          label: 'Número',
          align: 'left',
          field: 'numero',
          sortable: true
        },
        {
          name: 'origem',
          label: 'Origem',
          align: 'left',
          field: 'origem',
          sortable: true
        },
        {
          name: 'destino',
          label: 'Destino',
          align: 'left',
          field: 'destino'
        },
        {
          name: 'editar',
          label: 'Editar',
          align: 'center',
          field: 'editar',
          required: true
        }
      ],
      timer: ''
    }
  },
  validations: {
    maloteDocumento: {
      tipoDocumento: { required },
      numero: { required },
      setor: { required },
      rotaEndereco: { required }
    }
  },
  methods: {
    reset () {
      this.$v.maloteDocumento.$reset()
      this.maloteDocumento = new MaloteDocumento()
      this.maloteDocumento.rota = this.rota
      this.botaoSalvarAlterar = 'Gravar'
    },
    carrega (id) {
      console.log('vou carregar o maloteDocumento')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      maloteDocumentoService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o maloteDocumento com sucesso')
          this.maloteDocumento = Object.assign({}, this.maloteDocumento, result.data)
          this.botaoSalvarAlterar = 'Alterar'
        })
    },
    salvarAlterar () {
      this.maloteDocumento.rota = this.rota
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.$v.maloteDocumento.$touch()
        if (this.$v.maloteDocumento.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          })
          return
        }
        if (this.maloteDocumento.maloteDocumento && this.possoAlterarMaloteDocumento) {
          console.log('estou alterando o form')
          maloteDocumentoService.altera(this.maloteDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('maloteDocumento alterado com sucesso')
              this.listaDocumentos(this.malote)
              this.$q.notify({
                type: 'positive',
                message: 'Documento do malote alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.maloteDocumento.maloteDocumento && this.possoGravarMaloteDocumento) {
          this.maloteDocumento.malote = this.malote
          maloteDocumentoService.grava(this.maloteDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('maloteDocumento criado com sucesso')
              this.maloteDocumento.maloteDocumento = result.data.maloteDocumento
              this.maloteDocumento.usuarioCriador = result.data.usuarioCriador
              this.$q.notify({
                type: 'positive',
                message: 'Documento do malote criado com sucesso.',
                timeout: 5000
              })

              // limpando o form
              this.reset()
              this.preencheListaTabela(result.data.maloteDocumento.lista)
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir (id) {
      if (this.possoExcluirMaloteDocumento) {
        this.$q.dialog({
          title: 'Tem certeza?',
          message: 'Ao confirmar esta operação, não poderá desfazer.',
          ok: 'Sim, excluir',
          cancel: 'Cancelar'
        }).onOk(() => {
          this.$q.loading.show({
            message: 'Processando sua requisição',
            messageColor: 'white',
            spinnerSize: 250, // in pixels
            spinnerColor: 'white'
          })

          maloteDocumentoService.apaga(this.maloteDocumento.maloteDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('maloteDocumento removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'MaloteDocumento removido com sucesso.',
                timeout: 5000
              })
              let idRegistro = this.listaDeMaloteDocumentos.filter(registro => registro.id === this.maloteDocumento.maloteDocumento)
              this.listaDeMaloteDocumentos.splice(this.listaDeMaloteDocumentos.indexOf(idRegistro[0]), 1)
              this.reset()
            })
        })
      } else {
        notify.semPermissao()
      }
    },
    listaDocumentos (malote) {
      this.carregandoLista = true
      maloteDocumentoService
        .lista(malote)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de maloteDocumentos')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
      registros.forEach(maloteDocumento => {
        lista.push({
          id: maloteDocumento.maloteDocumento,
          tipoDocumento: maloteDocumento.tipoDocumentoDescricao,
          numero: maloteDocumento.numero,
          origem: maloteDocumento.setorDescricao,
          destino: maloteDocumento.codigoReduzido
        })
      })
      this.listaDeMaloteDocumentos = lista
    },
    setOptions (rota) {
      maloteDocumentoService.getOptions(rota)
        .then(result => {
          this.optionsLoading = false
          this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
          this.optionsRotaEndereco = this.rotaEndereco.setOptions(result.data.rotaEndereco)
          this.optionsSetor = this.setor.setOptions(result.data.setor)
        })
    }
  },
  props: [
    'malote',
    'rota'
  ],
  computed: {
    possoGravarMaloteDocumento: () => permissoes.gravar('maloteDocumento'),
    possoAbrirMaloteDocumento: () => permissoes.abrir('maloteDocumento'),
    possoExcluirMaloteDocumento: () => permissoes.excluir('maloteDocumento'),
    possoAlterarMaloteDocumento: () => permissoes.alterar('maloteDocumento')
  },
  mounted () {
    console.log('vou carregar a lista de maloteDocumento')
    this.listaDocumentos(this.malote)

    this.optionsLoading = true
    this.maloteDocumento.malote = this.malote
    this.setOptions(this.rota)
  }
}
</script>
