<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add">Novo</q-btn>
          <q-btn small type="submit" icon="search">Procurar</q-btn>
          <q-btn small type="button" @click="gerarRelatorio" icon="search" v-show="tipoConsulta === 'protocolo'">Imprimir</q-btn>
        </div>
      </div>
      <div>

        <q-collapsible label="Consulta" opened>
          <!-- <div class="row">
            <div class="col-md-3">
              <q-field class="form-input"
                label="Tipo do Documento"
                orientation="vertical"
              >
                <q-select
                  v-model="consultaMalote.tipoBusca"
                  :options="optionsTipoBusca"
                  filter
                  autofocus-filter
                  filter-placeholder="Selecione o tipo de busca"
                  name="select"
                />
              </q-field>
            </div>
          </div> -->
          <div class="row">
            <!-- <div class="col-md-6">
              <q-field class="form-input"
                label="Tipo de Relatório"
                orientation="vertical"
              >
                <q-select
                  v-model="buscaMalote.tipoRelatorio"
                  :options="optionsTipoRelatorio"
                  filter-placeholder="Selecione a Tipo de Relatório"
                  @input="trocaRelatorio"

                />
              </q-field>
            </div> -->
            <div class="col-md-12">
              <q-field class="form-input"
                label="Tipo de Consulta"
                orientation="vertical"
              >
                <q-select
                  v-model="tipoConsulta"
                  :options="optionsConsulta"
                  filter
                  autofocus-filter
                  filter-placeholder="Selecione a forma de consulta"
                  @input="trocaRelatorio"
                  name="select"
                />
              </q-field>
            </div>
          </div>
          <div class="row" v-show="tipoConsulta === 'protocolo'">

            <div class="col-md-3">
              <q-field
                label="Número de Protocolo"
                orientation="vertical"
                class="form-input"
                :error="$v.buscaMalote.protocolo.$error"
                error-label="Obrigatório"
                helper="Obrigatório"
              >
                <q-input
                  autocomplete="off"
                  type="text"
                  v-model="buscaMalote.protocolo"
                  name="number"
                  @input="$v.buscaMalote.protocolo.$touch()"
                />
              </q-field>
            </div>
            <div class="col-md-3">
              <q-field class="form-input"
                label="Ano"
                orientation="vertical"
              >
                <q-select
                  v-model="buscaMalote.ano"
                  :options="optionsAno"
                  placeholder="Selecione o ano"
                  name="select"
                />
              </q-field>
            </div>
          </div>
          <div v-show="tipoConsulta === 'documento'">

            <div class="row" >
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Tipo do Documento"
                  orientation="vertical"
                >
                  <q-select
                    v-model="buscaMalote.tipoDocumento"
                    :options="optionsTipoDocumento"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o tipo do documento"
                    name="select"
                  />
                </q-field>
              </div>

              <div class="col-md-3">
                <q-field
                  label="Número do Documento"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaMalote.numero" name="number"/>
                </q-field>
              </div>

            <!-- <div class="row">
              <div class="col-md-4">
                <q-field
                  label="Data ou Período?"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-radio v-model="buscaMalote.tipoData" val="data" label="Data do Cadastro" />
                  <q-radio v-model="buscaMalote.tipoData" val="periodo" label="Período do Cadastro" />
                  <q-radio v-model="buscaMalote.tipoData" val="mes" label="Mês do Cadastro" />
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'data'">
                <q-field
                  label="Data do Cadastro"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataCadastro" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'periodo'">
                <q-field
                  label="Data inicial"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataInicial" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'periodo'">
                <q-field
                  label="Data Final"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataFinal" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'mes'">
                <q-field
                  label="Mês do cadastro"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="month" v-model="buscaMalote.mesCadastro" name="date"/>
                </q-field>
              </div>
            </div> -->
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                >
                  <q-select
                    v-model="buscaMalote.setor"
                    :options="optionsSetor"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o setor"
                    name="select"
                  />
                </q-field>
              </div>
              <div class="col-md-3">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                >
                  <q-select
                    v-model="buscaMalote.rotaEndereco"
                    :options="optionsRotaEndereco"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o Endereço"
                    name="select"
                  />
                </q-field>
              </div>
            </div>

          </div>

        </q-collapsible>
      </div>
    </form>
    <br>
    <q-card v-show="malote.protocolo">
      <q-card-title>
        <strong>Malote nº {{malote.protocolo}}</strong>
      </q-card-title>
      <q-card-separator />
      <q-card-main>
        <div class="row">
          <div class="col-3"><strong>Data:</strong> {{malote.data}}</div>
          <div class="col-3"><strong>Lacre:</strong> {{malote.lacre}}</div>
          <div class="col-3"><strong>Bolsa:</strong> {{malote.numeroBolsa}}</div>
          <div class="col-3"><strong>Rota:</strong> {{malote.rotaDescricao}}</div>
        </div>
      </q-card-main>
    </q-card>
    <br>
    <div>

      <q-table title="Listagem de Documentos"
        :data="registros"
        :columns="tabelaColunas"
        row-key="maloteDocumento"
        :loading="carregandoLista"
        :separator="tabelaSeparador"
        no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados"
        rows-per-page-label="Linhas por página"
        loading-label="Carregando"
        :rows-per-page-options="[50,100,200,0]"
        :visible-columns="colunasVisiveis"
      >
        <template slot="top-left">
          <q-search
            placeholder="Busca"
            hide-underline
            color="secondary"
            v-model="registros"
            class="col-6"
          />
        </template>
        <template slot="top-right" slot-scope="props">
          <q-table-columns
            color="secondary"
            class="q-mr-sm"
            v-model="colunasVisiveis"
            :columns="tabelaColunas"
            label="Colunas"
          />
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
          <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarMalote', params: { id: props.row.malote} }"/>
          <!-- <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarMalote', params: { id: props.row.malote} }"/> -->
        </q-td>

      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>

    <!-- <q-page-sticky position="bottom-right" :offset="[18, 18]" v-if="
      possoGravarMalote ||
      possoExcluirMalote
    ">
      <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
        <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
          Botões de ação
        </q-tooltip>
        <q-fab-action color="positive" icon="save" @click="salvarAlterar" v-if="possoGravarMalote || possoAlterarMalote">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">{{ botaoSalvarAlterar }}</q-tooltip>
        </q-fab-action>
        <q-fab-action color="secondary" type="reset" @click="reset" icon="add" v-if="possoGravarMalote">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Novo</q-tooltip>
        </q-fab-action>
        <q-fab-action color="negative" type="button" @click="excluir" icon="delete" v-if="possoExcluirMalote">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Excluir</q-tooltip>
        </q-fab-action>
      </q-fab>
    </q-page-sticky> -->
    <q-modal ref="modalRelatorio" maximized v-model="modalRelatorio">
        <q-modal-layout
          header-style="min-height: 100px"
          content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}"
          footer-class="bg-primary some-class"
          footer-style="{fontSize: '24px', fontWeight: 'bold'}"
        >
          <q-toolbar class="primary">
            <q-btn flat @click="modalRelatorio = false">
              <q-icon name="keyboard_arrow_left" />
            </q-btn>
            <div class="q-toolbar-title">
              Relatório
            </div>
          </q-toolbar>
          <iframe class="full-width full-height"
            :src="linkRelatorio"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </q-modal-layout>
      </q-modal>

  </q-page>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
// import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import BuscaMalote from 'src/services/buscaMalote/BuscaMalote'
import buscaMaloteService from 'src/services/buscaMalote/BuscaMaloteService'
import TipoDocumento from 'src/services/tipoDocumento/TipoDocumento'
import Malote from 'src/services/malote/Malote'
import Endereco from 'src/services/endereco/Endereco'
import RotaEndereco from 'src/services/rotaEndereco/RotaEndereco'
import Setor from 'src/services/setor/Setor'
import { filter } from 'quasar'

export default {
  name: 'ConsultaMalote',
  directives: {
    mask
  },
  components: {
  },
  data () {
    return {
      modalRelatorio: false,
      linkRelatorio: '',
      valorTotal: 0,
      tipoDocumento: new TipoDocumento(),
      endereco: new Endereco(),
      rotaEndereco: new RotaEndereco(),
      setor: new Setor(),
      malote: new Malote(),
      optionsLoading: false,
      optionsSetor: [],
      optionsAno: [],
      optionsRotaEndereco: [],
      optionsTipoDocumento: [],
      busca: '',
      buscaMalote: new BuscaMalote(),
      carregandoLista: false,
      registros: [],
      tipoConsulta: 'protocolo',
      optionsTipoRelatorio: [
        {
          label: 'Listagem de Malote',
          value: 'listagemDeMalote'
        }
      ],
      optionsConsulta: [
        {
          label: 'Número do Protocolo',
          value: 'protocolo'
        },
        {
          label: 'Dados do documento',
          value: 'documento'
        }
      ],
      tabelaSeparador: 'horizontal',
      colunasVisiveis: new BuscaMalote().setColunasVisiveisListagemMalotes(),
      tabelaColunas: new BuscaMalote().setTabelaColunasListagemMalotes()

    }
  },
  validations: {
    buscaMalote: {
      ano: { required },
      protocolo: { required }
    }
  },
  methods: {
    parseEnderecos () {
      return this.optionsRotaEndereco.map(endereco => {
        // console.log(endereco)

        return {
          label: endereco.label,
          value: endereco.value
        }
      })
    },
    search (terms, done) {
      setTimeout(() => {
        done(filter(terms, {field: 'value', list: this.parseEnderecos()}))
      }, 1000)
    },
    setOptionsAno (anos) {
      if (anos.length > 0) {
        let optionsAno = []
        anos.map(ano => optionsAno.push(
          {
            label: `${ano.ano}`,
            value: `${ano.ano}`
          }
        ))
        this.optionsAno = optionsAno
      } else {
        this.optionsAno = [{
          label: 'Sem registros cadastrados, confira o cadastro de Malotes',
          value: ''
        }]
      }
    },

    reset () {
      this.$v.buscaMalote.$reset()
      this.buscaMalote = new BuscaMalote()
      this.malote = new Malote()
      this.registros = []
      this.tabelaColunas = this.buscaMalote.setTabelaColunasListagemMalotes()
      this.colunasVisiveis = this.buscaMalote.setColunasVisiveisListagemMalotes()
    },
    trocaRelatorio () {
      this.buscaMalote = new BuscaMalote()
      this.malote = new Malote()
      this.registros = []
      if (this.tipoConsulta === 'protocolo') {
        this.tabelaColunas = this.buscaMalote.setTabelaColunasListagemMalotes()
        this.colunasVisiveis = this.buscaMalote.setColunasVisiveisListagemMalotes()
      } else if (this.tipoConsulta === 'documento') {
        this.tabelaColunas = this.buscaMalote.setTabelaColunasDocumentosMalotes()
        this.colunasVisiveis = this.buscaMalote.setColunasVisiveisDocumentosMalotes()
      }
    },
    carrega (id) {
      console.log('vou carregar o buscaMalote', id)
      this.$router.push({ name: 'alterarMalote', params: { id } })
    },
    procurar () {
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(timer)
      timer = setTimeout(() => {
        this.$v.buscaMalote.$touch()
        if (this.$v.buscaMalote.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

        if (this.tipoConsulta === 'protocolo') {
          buscaMaloteService.seleciona(this.buscaMalote)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaMalote alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data.maloteDocumentos
              this.malote = result.data.malote

              this.$q.notify({
                type: 'positive',
                message: 'Estes foram os registros encontrados.',
                timeout: 5000
              })
            })
        } else {
          buscaMaloteService.procuraDocumento(this.buscaMalote)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaMalote alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data
              this.$q.notify({
                type: 'positive',
                message: 'Estes foram os registros encontrados.',
                timeout: 5000
              })
            })
        }
      }, 2000)
    },
    gerarRelatorio () {
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(timer)
      timer = setTimeout(() => {
        buscaMaloteService.relatorio(this.buscaMalote)
          .then(result => {
            this.$q.loading.hide()
            console.log('buscaMalote alterado com sucesso')
            // this.listaDocumentos()
            console.log(result.data)
            this.linkRelatorio = result.data.link
            this.modalRelatorio = true
            this.$q.notify({
              type: 'positive',
              message: 'Estes foram os registros encontrados.',
              timeout: 5000
            })
          })
      }, 2000)
    },
    listaDocumentos () {
      this.carregandoLista = true
      buscaMaloteService
        .lista(this.malote)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de buscaMalotes')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
      registros.forEach(buscaMalote => {
        lista.push({
          id: buscaMalote.buscaMalote,
          tipoDocumento: buscaMalote.tipoDocumentoDescricao,
          numero: buscaMalote.numero,
          origem: buscaMalote.setorDescricao,
          destino: buscaMalote.codigoReduzido
        })
      })
      this.listaDeMalotes = lista
    }
  },
  computed: {
    possoAbrirMalote: () => permissoes.abrir('malote')
  },
  mounted () {
    // this.listaDocumentos()

    // this.optionsLoading = true
    // this.buscaMalote.malote = this.malote
    buscaMaloteService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsAno(result.data.anos)
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsRotaEndereco = this.rotaEndereco.setOptions(result.data.rotaEndereco)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
      })
  }
}
</script>
