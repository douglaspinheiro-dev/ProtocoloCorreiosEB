<template>
  <q-page class="q-pa-sm full-height">
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
        <q-collapsible label="Documentos" opened>
          <div>
            <div class="row">
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Tipo do Documento"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.maloteDocumento.tipoDocumento.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="maloteDocumento.tipoDocumento"
                    :options="optionsTipoDocumento"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione a Origem"
                    name="select"
                    @input="$v.maloteDocumento.tipoDocumento.$touch()"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>

              <div class="col-md-3">
                <q-field
                  label="Número"
                  orientation="vertical"
                  class="form-input"
                  helper="Obrigatório"
                  :error="$v.maloteDocumento.numero.$error"
                  error-label="Obrigatório"
                >
                  <q-input type="tel" v-model="maloteDocumento.numero" @input="$v.maloteDocumento.numero.$touch()" name="numero"/>
                </q-field>
              </div>
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.maloteDocumento.setor.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="maloteDocumento.setor"
                    :options="optionsSetor"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione a Origem"
                    name="select"
                    @input="$v.maloteDocumento.setor.$touch()"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>

              <div class="col-md-3">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.maloteDocumento.rotaEndereco.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="maloteDocumento.rotaEndereco"
                    :options="optionsRotaEndereco"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione a Origem"
                    name="select"
                    @input="$v.maloteDocumento.rotaEndereco.$touch()"
                  />
                  <q-progress indeterminate v-show="optionsLoading"/>
                </q-field>
              </div>
            </div>
          </div>
        </q-collapsible>
      </q-list>
    </form>
    <br>
    <div>

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
        <template slot="top-left" slot-scope="props">
          <q-search
            placeholder="Busca"
            hide-underline
            color="secondary"
            v-model="buscaMaloteDocumento"
            class="col-6"
          />
        </template>
        <template slot="top-right" slot-scope="props">
          <q-select
            color="secondary"
            v-model="tabelaSeparador"
            :options="[
              { label: 'Horizontal', value: 'horizontal' },
              { label: 'Vertical', value: 'vertical' },
              { label: 'Célula', value: 'cell' },
              { label: 'Nenhum', value: 'none' }
            ]"
            hide-underline
          />
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

    <q-page-sticky position="bottom-right" :offset="[18, 18]" v-if="
      possoGravarMaloteDocumento ||
      possoExcluirMaloteDocumento
    ">
      <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
        <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
          Botões de ação
        </q-tooltip>
        <q-fab-action color="positive" icon="save" @click="salvarAlterar" v-if="possoGravarMaloteDocumento || possoAlterarMaloteDocumento">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">{{ botaoSalvarAlterar }}</q-tooltip>
        </q-fab-action>
        <q-fab-action color="secondary" type="reset" @click="reset" icon="add" v-if="possoGravarMaloteDocumento">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Novo</q-tooltip>
        </q-fab-action>
        <q-fab-action color="negative" type="button" @click="excluir" icon="delete" v-if="possoExcluirMaloteDocumento">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Excluir</q-tooltip>
        </q-fab-action>
      </q-fab>
    </q-page-sticky>
  </q-page>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import MaloteDocumento from 'src/services/maloteDocumento/MaloteDocumento'
import maloteDocumentoService from 'src/services/maloteDocumento/MaloteDocumentoService'

export default {
  name: 'MaloteDocumento',
  directives: {
    mask
  },
  data () {
    return {
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
      ]
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
    setOptionsRotaEndereco (enderecos) {
      if (enderecos.length > 0) {
        let optionsRotaEndereco = []
        enderecos.map(endereco => optionsRotaEndereco.push(
          {
            label: `${endereco.codigoReduzido} - ${endereco.descricao}`,
            value: endereco.rotaEndereco
          }
        ))
        this.optionsRotaEndereco = optionsRotaEndereco
      } else {
        this.optionsRotaEndereco = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    setOptionsTipoDocumento (tipoDocumentos) {
      if (tipoDocumentos.length > 0) {
        let optionsTipoDocumento = []
        tipoDocumentos.map(tipoDocumento => optionsTipoDocumento.push(
          {
            label: `${tipoDocumento.codigo}`,
            value: tipoDocumento.tipoDocumento
          }
        ))
        this.optionsTipoDocumento = optionsTipoDocumento
      } else {
        this.optionsTipoDocumento = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    setOptionsSetor (setors) {
      if (setors.length > 0) {
        let optionsSetor = []
        setors.map(setor => optionsSetor.push(
          {
            label: `${setor.codigoReduzido} - ${setor.descricao}`,
            value: setor.setor
          }
        ))
        this.optionsSetor = optionsSetor
      } else {
        this.optionsSetor = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
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
      clearTimeout(timer)
      timer = setTimeout(() => {
        this.$v.maloteDocumento.$touch()
        if (this.$v.maloteDocumento.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }
        if (this.maloteDocumento.maloteDocumento && this.possoAlterarMaloteDocumento) {
          console.log('estou alterando o form')
          maloteDocumentoService.altera(this.maloteDocumento)
            .then(result => {
              this.$q.loading.hide()
              console.log('maloteDocumento alterado com sucesso')
              this.listaDocumentos()
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
      console.log(id)

      if (this.possoExcluirMaloteDocumento) {
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

          maloteDocumentoService.apaga({maloteDocumento: id, rota: this.rota})
            .then(result => {
              this.$q.loading.hide()
              console.log('maloteDocumento removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'MaloteDocumento removido com sucesso.',
                timeout: 5000
              })
              let idRegistro = this.listaDeMaloteDocumentos.filter(registro => registro.id === id)
              this.listaDeMaloteDocumentos.splice(this.listaDeMaloteDocumentos.indexOf(idRegistro[0]), 1)
              this.reset()
            })
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
      } else {
        notify.semPermissao()
      }
    },
    listaDocumentos () {
      this.carregandoLista = true
      maloteDocumentoService
        .lista(this.malote)
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
    this.listaDocumentos()

    this.optionsLoading = true
    this.maloteDocumento.malote = this.malote
    maloteDocumentoService.getOptions(this.rota)
      .then(result => {
        this.optionsLoading = false
        this.setOptionsRotaEndereco(result.data.rotaEndereco)
        this.setOptionsTipoDocumento(result.data.tipoDocumento)
        this.setOptionsSetor(result.data.setor)
      })
  }
}
</script>
