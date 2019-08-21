<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add">Novo</q-btn>
          <q-btn small type="submit" icon="search">Procurar</q-btn>
          <q-btn small type="button" @click="gerarRelatorio" icon="print">Gerar Relatório</q-btn>
        </div>
      </div>
      <div>
        <!-- <div class="row">
          <div class="col-md-3">
              <q-field class="form-input"
                label="Tipo do Documento"
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
            </div>
        </div> -->
        <div class="row">
          <div class="col-md-6">
            <form-select classe="form-input" label="Tipo de Relatório" v-model="buscaCorrespondencia.tipoRelatorio"
              :options="optionsTipoRelatorio" @input="trocaRelatorio" />
          </div>
          <div class="col-md-6">
            <form-select classe="form-input" label="Tipo de Consulta" v-model="tipoConsulta" :options="optionsConsulta"
              @input="reset" />
          </div>
        </div>
        <div class="row" v-show="tipoConsulta === 'protocolo'">

          <div class="col-md-3">
            <q-input label="Número de Protocolo" class="form-input" autocomplete="off"
              v-model="buscaCorrespondencia.protocolo" />
          </div>
          <div class="col-md-3">
            <form-select classe="form-input" label="Ano" v-model="buscaCorrespondencia.ano" :options="optionsAno" />
          </div>
        </div>
        <div v-show="tipoConsulta === 'documento'">

          <div class="row">
            <div class="col-md-4">
              <q-input label="Código de Rastreio" class="form-input" autocomplete="off" type="text"
                v-model="buscaCorrespondencia.codigoRastreio" name="text" />
            </div>
            <div class="col-md-4">
                <q-input label="Remetente" class="form-input" type="text" v-model="buscaCorrespondencia.remetente" name="text" />
            </div>
            <div class="col-md-4">
                <q-input label="Número do Documento" class="form-input" autocomplete="off" type="text" v-model="buscaCorrespondencia.numero" name="number" />
            </div>

          </div>
          <div class="row">
            <div class="col-md-4">
              <q-field label="Data ou Período?" class="form-input" stack-label borderless="">
                <q-option-group inline
                  v-model="buscaCorrespondencia.tipoData"
                  :options="[
                    {label: 'Data', value: 'data'},
                    {label: 'Período', value: 'periodo'},
                    {label: 'Mês', value: 'mes'}
                  ]"
                  color="primary"
                />
              </q-field>
            </div>
            <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'data'">
                <q-input stack-label label="Data do Documento" class="form-input" autocomplete="off" type="date" v-model="buscaCorrespondencia.dataCadastro" name="date" />
            </div>
            <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'periodo'">
                <q-input stack-label="" label="Data inicial" class="form-input" autocomplete="off" type="date" v-model="buscaCorrespondencia.dataInicial" name="date" />
            </div>
            <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'periodo'">
                <q-input stack-label="" label="Data Final" class="form-input" autocomplete="off" type="date" v-model="buscaCorrespondencia.dataFinal" name="date" />
            </div>
            <div class="col-md-4" v-show="buscaCorrespondencia.tipoData === 'mes'">
                <q-input stack-label="" label="Mês do cadastro" class="form-input" autocomplete="off" type="month" v-model="buscaCorrespondencia.mesCadastro" name="date" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <form-select classe="form-input" label="Origem" v-model="buscaCorrespondencia.setor"
              :options="optionsSetor"/>
            </div>
            <div class="col-md-6">
              <q-input class="form-input" label="Destino" autocomplete="on" type="text" v-model="buscaCorrespondencia.destino">
                <!-- <q-autocomplete
                    @search="search"
                    :min-characters="3"
                  /> -->
              </q-input>
            </div>
          </div>

        </div>

      </div>
    </form>
    <br>
    <div>

      <q-table title="Listagem de Registros" :data="registros" :columns="tabelaColunas" row-key="correspondencia"
        :loading="carregandoLista" :separator="tabelaSeparador" no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados" rows-per-page-label="Linhas por página" loading-label="Carregando"
        :rows-per-page-options="[50,100,200,0]" :visible-columns="colunasVisiveis">
        <template slot="top-left">
          <!-- <q-search
            placeholder="Busca"
            hide-underline
            color="secondary"
            v-model="registros"
            class="col-6"
          /> -->
        </template>
        <template slot="top-right" slot-scope="props">
          <!-- <q-table-columns
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
          /> -->
          <q-btn flat round dense :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen" />
        </template>
        <q-td slot="body-cell-editar" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round icon="edit"
            :to="{ name: 'alterarCorrespondencia', params: { id: props.row.correspondencia} }" />
          <!-- <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarCorrespondencia', params: { id: props.row.correspondencia} }"/> -->
        </q-td>

        <q-tr slot="bottom-row" slot-scope="props" :props="props"
          v-show="buscaCorrespondencia.tipoRelatorio === 'listagemDeCorrespondencia'">
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
    <q-dialog ref="modalRelatorio" maximized v-model="modalRelatorio">
      <q-layout header-style="min-height: 100px" content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}"
        footer-class="bg-primary some-class" footer-style="{fontSize: '24px', fontWeight: 'bold'}">
        <q-toolbar class="primary">
          <q-btn flat @click="modalRelatorio = false">
            <q-icon name="keyboard_arrow_left" />
          </q-btn>
          <div class="q-toolbar-title">
            Relatório
          </div>
        </q-toolbar>
        <iframe class="full-width full-height" :src="linkRelatorio" frameborder="0" allowfullscreen></iframe>
      </q-layout>
    </q-dialog>

  </q-page>
</template>

<script>
// import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
// import notify from 'src/tools/Notify'
import {
  mask
} from 'vue-the-mask'
import BuscaCorrespondencia from './BuscaCorrespondencia'
import buscaCorrespondenciaService from './BuscaCorrespondenciaService'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import Setor from 'src/pages/cadastro/setor/Setor'
import formSelect from 'src/components/form/select/QSelect'

export default {
  name: 'ConsultaCorrespondencia',
  directives: {
    mask
  },
  components: {
    formSelect
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
      optionsTipoRelatorio: [{
        label: 'Listagem de Correspondências',
        value: 'listagemDeCorrespondencia'
      },
      {
        label: 'Controle de Registro de Postagem',
        value: 'controleDeRegistroDePostagem'
      }
      ],
      optionsConsulta: [{
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
    setOptionsAno (anos) {
      if (anos.length > 0) {
        let optionsAno = []
        anos.map(ano => optionsAno.push({
          label: `${ano.ano}`,
          value: `${ano.ano}`
        }))
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
      this.$router.push({
        name: 'alterarCorrespondencia',
        params: {
          id
        }
      })
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
