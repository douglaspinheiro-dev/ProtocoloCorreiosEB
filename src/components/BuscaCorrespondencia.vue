<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add">Novo</q-btn>
          <q-btn small type="submit" icon="search">Procurar</q-btn>
          <q-btn small type="button" @click="gerarRelatorio" icon="search">Imprimir</q-btn>
        </div>
      </div>
      <div>

        <q-collapsible label="Consulta" opened>
          <div class="row">
            <!-- <div class="col-md-3">
              <q-field class="form-input"
                label="Tipo do Documento"
                orientation="vertical"
              >
                <q-select
                  v-model="consultaCorrespondencia.tipoBusca"
                  :options="optionsTipoBusca"
                  filter
                  autofocus-filter
                  filter-placeholder="Selecione o tipo de busca"
                  name="select"
                />
              </q-field>
            </div> -->
          </div>
          <div class="row">
            <div class="col-md-6">
              <q-field class="form-input"
                label="Tipo de Relatório"
                orientation="vertical"
              >
                <q-select
                  v-model="buscaCorrespondencia.tipoRelatorio"
                  :options="optionsTipoRelatorio"
                  filter-placeholder="Selecione a Tipo de Relatório"
                  @input="trocaRelatorio"

                />
              </q-field>
            </div>
            <div class="col-md-6">
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
                  @input="reset"
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
              >
                <q-input autocomplete="off" type="text" v-model="buscaCorrespondencia.protocolo" name="number"/>
              </q-field>
            </div>
            <div class="col-md-3">
              <q-field class="form-input"
                label="Ano"
                orientation="vertical"
              >
                <q-select
                  v-model="buscaCorrespondencia.ano"
                  :options="optionsAno"
                  placeholder="Selecione o ano"
                  name="select"
                />
              </q-field>
            </div>
          </div>
          <div v-show="tipoConsulta === 'documento'">

            <div class="row" >

              <div class="col-md-4">
                <q-field
                  label="Código de Rastreio"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaCorrespondencia.codigoRastreio" name="text"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field
                  label="Remetente"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaCorrespondencia.remetente" name="text"/>
                </q-field>
              </div>
              <div class="col-md-4">
                <q-field
                  label="Número do Documento"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaCorrespondencia.numero" name="number"/>
                </q-field>
              </div>

            </div>
            <div class="row">
              <div class="col-md-4">
                <q-field
                  label="Data ou Período?"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-radio v-model="buscaCorrespondencia.tipoData" val="data" label="Data do Cadastro" />
                  <q-radio v-model="buscaCorrespondencia.tipoData" val="periodo" label="Período do Cadastro" />
                  <q-radio v-model="buscaCorrespondencia.tipoData" val="mes" label="Mês do Cadastro" />
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'data'">
                <q-field
                  label="Data do Documento"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaCorrespondencia.dataCadastro" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'periodo'">
                <q-field
                  label="Data inicial"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaCorrespondencia.dataInicial" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'periodo'">
                <q-field
                  label="Data Final"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaCorrespondencia.dataFinal" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'mes'">
                <q-field
                  label="Mês do cadastro"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="month" v-model="buscaCorrespondencia.mesCadastro" name="date"/>
                </q-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                >
                  <q-select
                    v-model="buscaCorrespondencia.setor"
                    :options="optionsSetor"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o setor"
                    name="select"
                  />
                </q-field>
              </div>
              <div class="col-md-6">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                >

                  <q-input autocomplete="on" type="text" v-model="buscaCorrespondencia.destino" name="origem" >
                    <q-autocomplete
                      @search="search"
                      :min-characters="3"
                    />
                  </q-input>
                </q-field>
              </div>
            </div>

          </div>

        </q-collapsible>
      </div>
    </form>
    <br>
    <div>

      <q-table title="Listagem de Registros"
        :data="registros"
        :columns="tabelaColunas"
        row-key="correspondencia"
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
          <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarCorrespondencia', params: { id: props.row.correspondencia} }"/>
          <!-- <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarCorrespondencia', params: { id: props.row.correspondencia} }"/> -->
        </q-td>

        <q-tr slot="bottom-row" slot-scope="props" v-show="buscaCorrespondencia.tipoRelatorio === 'listagemDeCorrespondencia'">
          <q-td colspan="100%">
            <strong class="float-right">Valor Total R$: {{ valorTotal }}</strong>
          </q-td>
        </q-tr>
      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>

    <!-- <q-page-sticky position="bottom-right" :offset="[18, 18]" v-if="
      possoGravarCorrespondencia ||
      possoExcluirCorrespondencia
    ">
      <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
        <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
          Botões de ação
        </q-tooltip>
        <q-fab-action color="positive" icon="save" @click="salvarAlterar" v-if="possoGravarCorrespondencia || possoAlterarCorrespondencia">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">{{ botaoSalvarAlterar }}</q-tooltip>
        </q-fab-action>
        <q-fab-action color="secondary" type="reset" @click="reset" icon="add" v-if="possoGravarCorrespondencia">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Novo</q-tooltip>
        </q-fab-action>
        <q-fab-action color="negative" type="button" @click="excluir" icon="delete" v-if="possoExcluirCorrespondencia">
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
// import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
// import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import BuscaCorrespondencia from 'src/services/buscaCorrespondencia/BuscaCorrespondencia'
import buscaCorrespondenciaService from 'src/services/buscaCorrespondencia/BuscaCorrespondenciaService'
import TipoDocumento from 'src/services/tipoDocumento/TipoDocumento'
import Endereco from 'src/services/endereco/Endereco'
import Setor from 'src/services/setor/Setor'
import { filter } from 'quasar'

export default {
  name: 'ConsultaCorrespondencia',
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
      setor: new Setor(),
      optionsLoading: false,
      optionsSetor: [],
      optionsAno: [],
      optionsEndereco: [],
      optionsTipoDocumento: [],
      busca: '',
      buscaCorrespondencia: new BuscaCorrespondencia(),
      carregandoLista: false,
      registros: [],
      tipoConsulta: 'documento',
      optionsTipoRelatorio: [
        {
          label: 'Listagem de Correspondências',
          value: 'listagemDeCorrespondencia'
        },
        {
          label: 'Controle de Registro de Postagem',
          value: 'controleDeRegistroDePostagem'
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
      colunasVisiveis: new BuscaCorrespondencia().setColunasVisiveisListagemCorrespondencias(),
      tabelaColunas: new BuscaCorrespondencia().setTabelaColunasListagemCorrespondencias()

    }
  },
  // validations: {
  //   buscaCorrespondencia: {
  //     ano: { required },
  //     protocolo: { required }
  //   }
  // },
  methods: {
    parseEnderecos () {
      return this.optionsEndereco.map(endereco => {
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
          label: 'Sem registros cadastrados, confira o cadastro de Correspondencias',
          value: ''
        }]
      }
    },

    reset () {
      this.buscaCorrespondencia = new BuscaCorrespondencia()
      this.registros = []
      this.tabelaColunas = this.buscaCorrespondencia.setTabelaColunasListagemCorrespondencias()
      this.colunasVisiveis = this.buscaCorrespondencia.setColunasVisiveisListagemCorrespondencias()
    },
    trocaRelatorio () {
      if (this.buscaCorrespondencia.tipoRelatorio === 'controleDeRegistroDePostagem') {
        this.tabelaColunas = this.buscaCorrespondencia.setTabelaColunasControleDeRegistroDePostagem()
        this.colunasVisiveis = this.buscaCorrespondencia.setColunasVisiveisControleDeRegistroDePostagem()
      } else if (this.buscaCorrespondencia.tipoRelatorio === 'listagemDeCorrespondencia') {
        this.tabelaColunas = this.buscaCorrespondencia.setTabelaColunasListagemCorrespondencias()
        this.colunasVisiveis = this.buscaCorrespondencia.setColunasVisiveisListagemCorrespondencias()
      }
    },
    carrega (id) {
      console.log('vou carregar o buscaCorrespondencia', id)
      this.$router.push({ name: 'alterarCorrespondencia', params: { id } })
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
        // this.$v.buscaCorrespondencia.$touch()
        // if (this.$v.buscaCorrespondencia.$error) {
        //   this.$q.loading.hide()
        //   this.$q.dialog({
        //     title: 'Atenção',
        //     message: 'Alguns campos precisam ser corrigidos.'
        //   }).then(() => { }).catch(() => { })
        //   return
        // }

        if (this.buscaCorrespondencia.protocolo) {
          buscaCorrespondenciaService.seleciona(this.buscaCorrespondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaCorrespondencia alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data
              this.valorTotal = result.data[0].valorTotal

              this.$q.notify({
                type: 'positive',
                message: 'Estes foram os registros encontrados.',
                timeout: 5000
              })
            })
        } else {
          buscaCorrespondenciaService.procuraDocumento(this.buscaCorrespondencia)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaCorrespondencia alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data.correspondencias
              this.valorTotal = result.data.valorTotal
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
        buscaCorrespondenciaService.relatorio(this.buscaCorrespondencia)
          .then(result => {
            this.$q.loading.hide()
            console.log('buscaCorrespondencia alterado com sucesso')
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
      buscaCorrespondenciaService
        .lista(this.malote)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de buscaCorrespondencias')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
      registros.forEach(buscaCorrespondencia => {
        lista.push({
          id: buscaCorrespondencia.buscaCorrespondencia,
          tipoDocumento: buscaCorrespondencia.tipoDocumentoDescricao,
          numero: buscaCorrespondencia.numero,
          origem: buscaCorrespondencia.setorDescricao,
          destino: buscaCorrespondencia.codigoReduzido
        })
      })
      this.listaDeCorrespondencias = lista
    }
  },
  props: [
    'malote',
    'rota'
  ],
  computed: {
    possoAbrirCorrespondencia: () => permissoes.abrir('correspondencia')
  },
  mounted () {
    // this.listaDocumentos()

    // this.optionsLoading = true
    // this.buscaCorrespondencia.malote = this.malote
    buscaCorrespondenciaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsAno(result.data.anos)
        this.optionsTipoDocumento = this.tipoDocumento.setOptions(result.data.tipoDocumento)
        this.optionsEndereco = this.endereco.setOptions(result.data.endereco)
        this.optionsSetor = this.setor.setOptions(result.data.setor)
      })
  }
}
</script>
