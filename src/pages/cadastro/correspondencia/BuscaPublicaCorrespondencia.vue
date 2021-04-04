<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn
            small
            type="submit"
            icon="search"
          >Procurar</q-btn>
          <q-btn
            small
            type="button"
            @click="gerarRelatorio"
            icon="print"
          >Gerar Relatório</q-btn>
        </div>
      </div>

      <div class="row">
        <!-- <div class="col-md-3">
          <q-field
            label="Número do Documento"
            orientation="vertical"
            class="form-input"
          >
            <q-input
              autocomplete="off"
              type="text"
              v-model="buscaCorrespondencia.numero"
              name="number"
            />
          </q-field>
        </div> -->

        <div class="col-md-4">
          <q-field
            label="Mês do cadastro"
            orientation="vertical"
            class="form-input"
            helper="Obrigatório"
            :error="$v.buscaCorrespondencia.mes.$error"
            error-label="Obrigatório"
          >
            <q-select
              v-model="buscaCorrespondencia.mes"
              :options="optionsMes"
              filter
              autofocus-filter
              filter-placeholder="Selecione o mês"
              name="select"
            />
          </q-field>
        </div>
        <div class="col-md-4">
          <q-field
            class="form-input"
            label="Ano"
            orientation="vertical"
            helper="Obrigatório"
            :error="$v.buscaCorrespondencia.mes.$error"
            error-label="Obrigatório"
          >
            <q-select
              v-model="buscaCorrespondencia.ano"
              :options="optionsAno"
              filter
              autofocus-filter
              filter-placeholder="Selecione o ano"
              name="select"
            />
          </q-field>
        </div>
        <div class="col-md-4">
          <q-field
            class="form-input"
            label="Origem"
            orientation="vertical"
            helper="Obrigatório"
            :error="$v.buscaCorrespondencia.setor.$error"
            error-label="Obrigatório"
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
      </div>
    </form>
    <br>
    <div>

      <q-table
        title="Registro de Postagem"
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
        <template
          slot="top-right"
          slot-scope="props"
        >
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
            flat
            round
            dense
            :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen"
          />
        </template>
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
    <q-modal
      ref="modalRelatorio"
      maximized
      v-model="modalRelatorio"
    >
      <q-modal-layout
        header-style="min-height: 100px"
        content-class="{'bg-primary': isPrimary, 'some-class': someBoolean}"
        footer-class="bg-primary some-class"
        footer-style="{fontSize: '24px', fontWeight: 'bold'}"
      >
        <q-toolbar class="primary">
          <q-btn
            flat
            @click="modalRelatorio = false"
          >
            <q-icon name="keyboard_arrow_left" />
          </q-btn>
          <div class="q-toolbar-title">
            Relatório
          </div>
        </q-toolbar>
        <iframe
          class="full-width full-height"
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
let timer
import BuscaCorrespondencia from './BuscaCorrespondencia'
import buscaCorrespondenciaService from './BuscaCorrespondenciaService'
import Setor from 'src/pages/cadastro/setor/Setor'
import tools from 'src/tools'

export default {
  name: 'ConsultaCorrespondencia',
  data () {
    return {
      modalRelatorio: false,
      linkRelatorio: '',
      setor: new Setor(),
      optionsLoading: false,
      optionsSetor: [],
      busca: '',
      buscaCorrespondencia: new BuscaCorrespondencia(),
      carregandoLista: false,
      registros: [],
      tipoConsulta: 'documento',
      tabelaSeparador: 'horizontal',
      colunasVisiveis: new BuscaCorrespondencia().setColunasVisiveisControleDeRegistroDePostagem(),
      optionsMes: [
        { label: 'Janeiro', value: '01' },
        { label: 'Fevereiro', value: '02' },
        { label: 'Março', value: '03' },
        { label: 'Abril', value: '04' },
        { label: 'Maio', value: '05' },
        { label: 'Junho', value: '06' },
        { label: 'Julho', value: '07' },
        { label: 'Agosto', value: '08' },
        { label: 'Setembro', value: '09' },
        { label: 'Outubro', value: '10' },
        { label: 'Novembro', value: '11' },
        { label: 'Dezembro', value: '12' }
      ],
      optionsAno: [],
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
          name: 'origem',
          label: 'Origem - Remetente',
          align: 'left',
          field: 'origemRemetente',
          sortable: true
        },
        {
          name: 'tipoCorrespondencia',
          label: 'Tipo de Cor.',
          align: 'left',
          field: 'tipoCorrespondencia',
          sortable: true
        },
        {
          name: 'cep',
          label: 'CEP',
          align: 'left',
          field: 'cep',
          sortable: true
        },
        {
          name: 'codigoRastreio',
          label: 'Rastreio',
          align: 'left',
          field: 'codigoRastreio',
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
          name: 'numeroDocumento',
          label: 'Nº',
          align: 'left',
          field: 'numeroDocumento'
        }
      ]

    }
  },
  validations: {
    buscaCorrespondencia: {
      ano: { required },
      mes: { required },
      setor: { required }
    }
  },
  methods: {
    setOptionsAno (anos) {
      if (anos.length > 0) {
        const optionsAno = []
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
    procurar () {
      this.$v.buscaCorrespondencia.$touch()
      if (this.$v.buscaCorrespondencia.$error) {
        tools.Loadings.hide()
        this.$q.dialog({
          title: 'Atenção',
          message: 'Alguns campos precisam ser corrigidos.'
        }).then(() => { }).catch(() => { })
        return
      }
      this.buscaCorrespondencia.mesCadastro = `${this.buscaCorrespondencia.ano}-${this.buscaCorrespondencia.mes}`
      tools.Loadings.processando()
      clearTimeout(timer)
      timer = setTimeout(() => {
        buscaCorrespondenciaService.procuraDocumentoPublico(this.buscaCorrespondencia)
          .then(result => {
            tools.Loadings.hide()
            console.log('buscaCorrespondencia alterado com sucesso')
            // this.listaDocumentos()
            console.log(result.data)
            this.registros = result.data.correspondencias
            this.valorTotal = result.data.valorTotal
            this.$q.notify({
              type: 'positive',
              message: 'Este é o resultado da sua consulta.',
              timeout: 5000
            })
          })
      }, 2000)
    },
    gerarRelatorio () {
      this.$v.buscaCorrespondencia.$touch()
      if (this.$v.buscaCorrespondencia.$error) {
        tools.Loadings.hide()
        this.$q.dialog({
          title: 'Atenção',
          message: 'Alguns campos precisam ser corrigidos.'
        }).then(() => { }).catch(() => { })
        return
      }
      tools.Loadings.processando()
      this.buscaCorrespondencia.mesCadastro = `${this.buscaCorrespondencia.ano}-${this.buscaCorrespondencia.mes}`
      clearTimeout(timer)
      timer = setTimeout(() => {
        buscaCorrespondenciaService.relatorioPublico(this.buscaCorrespondencia)
          .then(result => {
            tools.Loadings.hide()
            console.log('buscaCorrespondencia alterado com sucesso')
            // this.listaDocumentos()
            console.log(result.data)
            this.linkRelatorio = result.data.link
            this.modalRelatorio = true
            this.$q.notify({
              type: 'positive',
              message: 'Este é o resultado da sua consulta.',
              timeout: 5000
            })
          })
      }, 2000)
    },
    preencheListaTabela (registros) {
      const lista = []
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
  mounted () {
    // this.listaDocumentos()

    // this.optionsLoading = true
    // this.buscaCorrespondencia.malote = this.malote
    buscaCorrespondenciaService.getOptionsPublico()
      .then(result => {
        this.optionsLoading = false
        this.optionsSetor = this.setor.setOptions(result.data.setor)
        this.setOptionsAno(result.data.anos)
      })
  }
}
</script>
<style scoped>
.input {
  margin-top: 20px;
}
.form-input{
  margin: 10px;
}
</style>
