<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add">Novo</q-btn>
          <q-btn small type="submit" icon="search">Procurar</q-btn>
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
            <div class="col-md-3">
              <q-field
                label="Número de Protocolo"
                orientation="vertical"
                class="form-input"
                helper="Obrigatório"
                :error="$v.buscaProtocoloEntrada.protocolo.$error"
                error-label="Obrigatório"
              >
                <q-input autocomplete="off" type="text" v-model="buscaProtocoloEntrada.protocolo" @input="$v.buscaProtocoloEntrada.protocolo.$touch()" name="number"/>
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
                  filter
                  autofocus-filter
                  filter-placeholder="Selecione o ano"
                  name="select"
                />
              </q-field>
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
        row-key="id"
        :loading="carregandoLista"
        :separator="tabelaSeparador"
        no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados"
        rows-per-page-label="Linhas por página"
        loading-label="Carregando"
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
        <!-- <q-td slot="body-cell-editar" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round icon="edit" @click="carrega(props.row.id)" />
        </q-td> -->
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
  </q-page>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
// import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import BuscaProtocoloEntrada from 'src/services/buscaProtocoloEntrada/BuscaProtocoloEntrada'
import buscaProtocoloEntradaService from 'src/services/buscaProtocoloEntrada/BuscaProtocoloEntradaService'

export default {
  name: 'ConsultaProtocoloEntrada',
  directives: {
    mask
  },
  data () {
    return {
      optionsLoading: false,
      optionsSetor: [],
      optionsAno: [],
      optionsRotaEndereco: [],
      busca: '',
      buscaProtocoloEntrada: new BuscaProtocoloEntrada(),
      carregandoLista: false,
      registros: [],
      tabelaSeparador: 'horizontal',
      tabelaColunas: [
        {
          name: 'protocolo',
          required: true,
          label: 'Protocolo',
          align: 'left',
          field: 'protocolo',
          sortable: true
        },
        {
          name: 'tipoDocumento',
          required: true,
          label: 'Tipo de Documento',
          align: 'left',
          field: 'tipoDocumento',
          sortable: true
        },
        {
          name: 'numero',
          label: 'nº',
          align: 'left',
          field: 'numero'
        },
        {
          name: 'dataDocumento',
          label: 'Data do doc.',
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
        }
      ]
    }
  },
  validations: {
    buscaProtocoloEntrada: {
      ano: { required },
      protocolo: { required }
    }
  },
  methods: {
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
      this.$v.buscaProtocoloEntrada.$reset()
      this.buscaProtocoloEntrada = new BuscaProtocoloEntrada()
    },
    carrega (id) {
      console.log('vou carregar o buscaProtocoloEntrada')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      buscaProtocoloEntradaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o buscaProtocoloEntrada com sucesso')
          this.buscaProtocoloEntrada = Object.assign({}, this.buscaProtocoloEntrada, result.data)
          this.botaoSalvarAlterar = 'Alterar'
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
        this.$v.buscaProtocoloEntrada.$touch()
        if (this.$v.buscaProtocoloEntrada.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }

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
          buscaProtocoloEntradaService.procura(this.buscaProtocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('buscaProtocoloEntrada alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.$q.notify({
                type: 'positive',
                message: 'Estes foram os registros encontrados.',
                timeout: 5000
              })
            })
        }
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
    console.log('vou carregar a lista de buscaProtocoloEntrada')
    // this.listaDocumentos()

    // this.optionsLoading = true
    // this.buscaProtocoloEntrada.malote = this.malote
    buscaProtocoloEntradaService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsAno(result.data.anos)
      })
  }
}
</script>
