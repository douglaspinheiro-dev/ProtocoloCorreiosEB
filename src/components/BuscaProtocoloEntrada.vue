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
                  v-model="consultaProtocoloEntrada.tipoBusca"
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
                <q-input autocomplete="off" type="text" v-model="buscaProtocoloEntrada.protocolo" name="number"/>
              </q-field>
            </div>
            <div class="col-md-3">
              <q-field class="form-input"
                label="Ano"
                orientation="vertical"
              >
                <q-select
                  v-model="buscaProtocoloEntrada.ano"
                  :options="optionsAno"
                  placeholder="Selecione o ano"
                  name="select"
                />
              </q-field>
            </div>
          </div>
          <div v-show="tipoConsulta === 'documento'">

            <div class="row" >

              <div class="col-md-6">
                <q-field
                  label="Número do Documento"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaProtocoloEntrada.numero" name="number"/>
                </q-field>
              </div>

              <div class="col-md-6">
                <q-field
                  label="Assunto"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="text" v-model="buscaProtocoloEntrada.assunto" name="text"/>
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
                  <q-radio v-model="buscaProtocoloEntrada.tipoData" val="data" label="Data do Documento" />
                  <q-radio v-model="buscaProtocoloEntrada.tipoData" val="periodo" label="Período do Cadastro" />
                  <q-radio v-model="buscaProtocoloEntrada.tipoData" val="mes" label="Mês do Cadastro" />
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaProtocoloEntrada.tipoData === 'data'">
                <q-field
                  label="Data do Documento"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaProtocoloEntrada.dataDocumento" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaProtocoloEntrada.tipoData === 'periodo'">
                <q-field
                  label="Data inicial"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaProtocoloEntrada.dataInicial" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaProtocoloEntrada.tipoData === 'periodo'">
                <q-field
                  label="Data Final"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaProtocoloEntrada.dataFinal" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaProtocoloEntrada.tipoData === 'mes'">
                <q-field
                  label="Mês do cadastro"
                  orientation="vertical"
                  class="form-input"
                >
                  <q-input autocomplete="off" type="month" v-model="buscaProtocoloEntrada.mesCadastro" name="date"/>
                </q-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <q-field class="form-input"
                  label="Origem"
                  orientation="vertical"
                >
                  <q-input autocomplete="on" type="text" v-model="buscaProtocoloEntrada.origem" name="origem" >
                    <q-autocomplete
                      @search="search"
                      :min-characters="3"
                    />
                  </q-input>
                </q-field>
              </div>
              <div class="col-md-6">
                <q-field class="form-input"
                  label="Destino"
                  orientation="vertical"
                >
                  <q-select
                    v-model="buscaProtocoloEntrada.setor"
                    :options="optionsSetor"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione o setor"
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
    <div>

      <q-table title="Listagem de Registros"
        :data="registros"
        :columns="tabelaColunas"
        row-key="protocoloEntrada"
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
          <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarProtocoloEntrada', params: { id: props.row.protocoloEntrada} }"/>
          <!-- <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarProtocoloEntrada', params: { id: props.row.protocoloEntrada} }"/> -->
        </q-td>
      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>

    <!-- <q-page-sticky position="bottom-right" :offset="[18, 18]" v-if="
      possoGravarProtocoloEntrada ||
      possoExcluirProtocoloEntrada
    ">
      <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
        <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
          Botões de ação
        </q-tooltip>
        <q-fab-action color="positive" icon="save" @click="salvarAlterar" v-if="possoGravarProtocoloEntrada || possoAlterarProtocoloEntrada">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">{{ botaoSalvarAlterar }}</q-tooltip>
        </q-fab-action>
        <q-fab-action color="secondary" type="reset" @click="reset" icon="add" v-if="possoGravarProtocoloEntrada">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Novo</q-tooltip>
        </q-fab-action>
        <q-fab-action color="negative" type="button" @click="excluir" icon="delete" v-if="possoExcluirProtocoloEntrada">
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
import BuscaProtocoloEntrada from 'src/services/buscaProtocoloEntrada/BuscaProtocoloEntrada'
import buscaProtocoloEntradaService from 'src/services/buscaProtocoloEntrada/BuscaProtocoloEntradaService'
import TipoDocumento from 'src/services/tipoDocumento/TipoDocumento'
import Endereco from 'src/services/endereco/Endereco'
import Setor from 'src/services/setor/Setor'
import { filter } from 'quasar'

export default {
  name: 'ConsultaProtocoloEntrada',
  directives: {
    mask
  },
  components: {
  },
  data () {
    return {
      modalRelatorio: false,
      linkRelatorio: '',
      tipoDocumento: new TipoDocumento(),
      endereco: new Endereco(),
      setor: new Setor(),
      optionsLoading: false,
      optionsSetor: [],
      optionsAno: [],
      optionsEndereco: [],
      optionsTipoDocumento: [],
      busca: '',
      buscaProtocoloEntrada: new BuscaProtocoloEntrada(),
      carregandoLista: false,
      registros: [],
      tipoConsulta: 'documento',
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
      colunasVisiveis: ['numero', 'dataDocumento', 'origem', 'assunto', 'destino', 'dataCadastro'],
      tabelaColunas: [
        {
          name: 'protocolo',
          required: true,
          label: 'Prot.',
          align: 'left',
          field: 'protocolo',
          sortable: true
        },
        {
          name: 'tipoDocumento',
          required: true,
          label: 'Tipo Doc.',
          align: 'left',
          field: 'tipoDocumento',
          sortable: true
        },
        {
          name: 'numero',
          label: 'Nº',
          align: 'left',
          field: 'numero'
        },
        {
          name: 'dataDocumento',
          label: 'Data Doc.',
          align: 'left',
          field: 'dataDocumento',
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
          name: 'assunto',
          label: 'Assunto',
          align: 'left',
          field: 'assunto',
          sortable: true
        },
        {
          name: 'destino',
          label: 'Destino',
          align: 'left',
          field: 'destino',
          sortable: true
        },
        {
          name: 'dataCadastro',
          label: 'Data do Cadastro',
          align: 'left',
          field: 'dataCadastro',
          sortable: true
        },
        {
          name: 'editar',
          label: 'Editar',
          align: 'center',
          field: 'protocoloEntrada',
          required: true
        }
      ]
    }
  },
  // validations: {
  //   buscaProtocoloEntrada: {
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
          label: 'Sem registros cadastrados, confira o cadastro de Protocolo de Entradas',
          value: ''
        }]
      }
    },

    reset () {
      this.$v.buscaProtocoloEntrada.$reset()
      this.buscaProtocoloEntrada = new BuscaProtocoloEntrada()
    },
    carrega (id) {
      console.log('vou carregar o buscaProtocoloEntrada', id)
      this.$router.push({ name: 'alterarProtocoloEntrada', params: { id } })
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
        // this.$v.buscaProtocoloEntrada.$touch()
        // if (this.$v.buscaProtocoloEntrada.$error) {
        //   this.$q.loading.hide()
        //   this.$q.dialog({
        //     title: 'Atenção',
        //     message: 'Alguns campos precisam ser corrigidos.'
        //   }).then(() => { }).catch(() => { })
        //   return
        // }

        if (this.buscaProtocoloEntrada.protocolo) {
          buscaProtocoloEntradaService.seleciona(this.buscaProtocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaProtocoloEntrada alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data
              this.$q.notify({
                type: 'positive',
                message: 'Estes foram os registros encontrados.',
                timeout: 5000
              })
            })
        } else {
          buscaProtocoloEntradaService.procuraDocumento(this.buscaProtocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaProtocoloEntrada alterado com sucesso')
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
        buscaProtocoloEntradaService.relatorio(this.buscaProtocoloEntrada)
          .then(result => {
            this.$q.loading.hide()
            console.log('buscaProtocoloEntrada alterado com sucesso')
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
      buscaProtocoloEntradaService
        .lista(this.malote)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de buscaProtocoloEntradas')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
      registros.forEach(buscaProtocoloEntrada => {
        lista.push({
          id: buscaProtocoloEntrada.buscaProtocoloEntrada,
          tipoDocumento: buscaProtocoloEntrada.tipoDocumentoDescricao,
          numero: buscaProtocoloEntrada.numero,
          origem: buscaProtocoloEntrada.setorDescricao,
          destino: buscaProtocoloEntrada.codigoReduzido
        })
      })
      this.listaDeProtocoloEntradas = lista
    }
  },
  props: [
    'malote',
    'rota'
  ],
  computed: {
    possoAbrirProtocoloEntrada: () => permissoes.abrir('protocoloEntrada')
  },
  mounted () {
    // this.listaDocumentos()

    // this.optionsLoading = true
    // this.buscaProtocoloEntrada.malote = this.malote
    buscaProtocoloEntradaService.getOptions()
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
