<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="procurar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add">Novo</q-btn>
          <q-btn small type="submit" icon="search">Procurar</q-btn>
          <q-btn small type="button" @click="gerarRelatorio" icon="print" v-show="tipoConsulta !== 'documento'">Gerar
            Relatório</q-btn>
        </div>
      </div>
      <div>

        <q-expansion-item label="Consulta" default-opened>
          <!-- <div class="row">
            <div class="col-md-3">
              <q-field class="form-input"
                label="Tipo do Documento"

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
              <form-select @input="trocaRelatorio" classe="form-input" label="Tipo de Consulta" v-model="tipoConsulta"
                :options="optionsConsulta" />
            </div>
          </div>
          <div class="row" v-show="tipoConsulta === 'protocolo'">

            <div class="col-md-3">
              <q-input label="Número de Protocolo"
                class="form-input"
                error-label="Obrigatório"
                helper="Obrigatório"
                autocomplete="off"
                type="text"
                v-model="buscaMalote.protocolo"
                @input="$v.buscaMalote.protocolo.$touch()"
                :error="$v.buscaMalote.protocolo.$error"
                error-message="Obrigatório"

                hint="Obrigatório"
              />
            </div>
            <div class="col-md-3">
              <form-select
                classe="form-input"
                label="Ano"
                v-model="buscaMalote.ano"
                :options="optionsAno"
                :error="$v.buscaMalote.ano.$error"
                error-message="Obrigatório"

                hint="Obrigatório"
              />
            </div>
          </div>
          <div class="row" v-show="tipoConsulta === 'mes'">

            <div class="col-md-3">
              <form-select
                classe="form-input"
                label="Mês"
                v-model="buscaMalote.mes"
                :options="optionsMes"
                @input="$v.buscaMalote.mes.$touch()"
                :error="$v.buscaMalote.mes.$error"
                error-message="Obrigatório"

              />
            </div>
            <div class="col-md-3">
              <form-select
                classe="form-input"
                label="Ano"
                v-model="buscaMalote.ano"
                :options="optionsAno"
                @input="$v.buscaMalote.ano.$touch()"
                :error="$v.buscaMalote.ano.$error"
                error-message="Obrigatório"

                hint="Obrigatório"
              />
            </div>
          </div>
          <div v-show="tipoConsulta === 'documento'">

            <div class="row">
              <div class="col-md-2">
                <form-select classe="form-input" label="Tipo do Documento" v-model="buscaMalote.tipoDocumento" :options="optionsTipoDocumento"/>
              </div>
              <div class="col-md-2">
                <q-input label="Número"  class="form-input" autocomplete="off" type="text" v-model="buscaMalote.numero" />
              </div>

              <!-- <div class="row">
              <div class="col-md-4">
                <q-field
                  label="Data ou Período?"

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

                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataCadastro" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'periodo'">
                <q-field
                  label="Data inicial"

                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataInicial" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'periodo'">
                <q-field
                  label="Data Final"

                  class="form-input"
                >
                  <q-input autocomplete="off" type="date" v-model="buscaMalote.dataFinal" name="date"/>
                </q-field>
              </div>
              <div class="col-md-4" v-show="buscaMalote.tipoData === 'mes'">
                <q-field
                  label="Mês do cadastro"

                  class="form-input"
                >
                  <q-input autocomplete="off" type="month" v-model="buscaMalote.mesCadastro" name="date"/>
                </q-field>
              </div>
            </div> -->
              <div class="col-md-4">
                <form-select classe="form-input" label="Origem" v-model="buscaMalote.setor"
                  :options="optionsSetor" />
              </div>
              <div class="col-md-4">
                <form-select classe="form-input" label="Destino" v-model="buscaMalote.rotaEndereco"
                  :options="optionsRotaEndereco" />
              </div>
            </div>

          </div>

        </q-expansion-item>
      </div>
    </form>
    <br>
    <q-card v-show="malote.protocolo">
      <q-card-section>
        <strong>Malote nº {{malote.protocolo}}</strong>
      </q-card-section>
      <q-separator />
      <q-card-section>
        <div class="row">
          <div class="col-3"><strong>Data:</strong> {{malote.data}}</div>
          <div class="col-3"><strong>Lacre:</strong> {{malote.lacre}}</div>
          <div class="col-3"><strong>Bolsa:</strong> {{malote.numeroBolsa}}</div>
          <div class="col-3"><strong>Rota:</strong> {{malote.rotaDescricao}}</div>
        </div>
      </q-card-section>
    </q-card>
    <br>
    <div>

      <q-table title="Listagem de Documentos" :data="registros" :columns="tabelaColunas" row-key="maloteDocumento"
        :loading="carregandoLista" :separator="tabelaSeparador" no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados" rows-per-page-label="Linhas por página" loading-label="Carregando"
        :rows-per-page-options="[50,100,200,0]" :visible-columns="colunasVisiveis">
        <template slot="top-left">
          <!-- <q-search placeholder="Busca" hide-underline color="secondary" v-model="registros" class="col-6" /> -->
        </template>
        <template slot="top-right" slot-scope="props">
          <!-- <q-table-columns color="secondary" class="q-mr-sm" v-model="colunasVisiveis" :columns="tabelaColunas" label="Colunas" /> -->
          <q-select color="secondary" v-model="tabelaSeparador" :options="[
              { label: 'Horizontal', value: 'horizontal' },
              { label: 'Vertical', value: 'vertical' },
              { label: 'Célula', value: 'cell' },
              { label: 'Nenhum', value: 'none' }
            ]" hide-underline />
          <q-btn flat round dense :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen" />
        </template>
        <q-td slot="body-cell-editar" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round icon="edit"
            :to="{ name: 'alterarMalote', params: { id: props.row.malote} }" />
          <!-- <q-btn type="button" color="primary" flat round icon="edit" :to="{ name: 'alterarMalote', params: { id: props.row.malote} }"/> -->
        </q-td>

      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>

  </q-page>
</template>

<script>
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import { requiredIf } from 'vuelidate/lib/validators'

// import notify from 'src/tools/Notify'
import {
  mask
} from 'vue-the-mask'
import BuscaMalote from 'src/pages/cadastro/malote/BuscaMalote'
import buscaMaloteService from 'src/pages/cadastro/malote/BuscaMaloteService'
import TipoDocumento from 'src/pages/cadastro/tipoDocumento/TipoDocumento'
import Malote from 'src/pages/cadastro/malote/Malote'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import RotaEndereco from 'src/pages/cadastro/rota/RotaEndereco'
import Setor from 'src/pages/cadastro/setor/Setor'
import formSelect from 'src/components/form/select/QSelect'
import tools from 'src/tools'

export default {
  name: 'ConsultaMalote',
  directives: {
    mask
  },
  components: {
    formSelect
  },
  data () {
    return {
      timer: '',
      valorTotal: 0,
      tipoDocumento: new TipoDocumento(),
      endereco: new Endereco(),
      rotaEndereco: new RotaEndereco(),
      setor: new Setor(),
      malote: new Malote(),
      optionsLoading: false,
      optionsSetor: [],
      optionsAno: [],
      optionsMes: [
        {
          label: 'Janeiro',
          value: '1'
        },
        {
          label: 'Fevereiro',
          value: '2'
        },
        {
          label: 'Março',
          value: '3'
        },
        {
          label: 'Abril',
          value: '4'
        },
        {
          label: 'Maio',
          value: '5'
        },
        {
          label: 'junho',
          value: '6'
        },
        {
          label: 'julho',
          value: '7'
        },
        {
          label: 'Agosto',
          value: '8'
        },
        {
          label: 'Setembro',
          value: '9'
        },
        {
          label: 'Outubro',
          value: '10'
        },
        {
          label: 'Novembro',
          value: '11'
        },
        {
          label: 'Dezembro',
          value: '12'
        }
      ],
      optionsRotaEndereco: [],
      optionsTipoDocumento: [],
      busca: '',
      buscaMalote: new BuscaMalote(),
      carregandoLista: false,
      registros: [],
      tipoConsulta: 'protocolo',
      optionsTipoRelatorio: [{
        label: 'Listagem de Malote',
        value: 'listagemDeMalote'
      }],
      optionsConsulta: [{
        label: 'Número do Protocolo',
        value: 'protocolo'
      },
      {
        label: 'Dados do documento',
        value: 'documento'
      },
      {
        label: 'Consolidado por Mês',
        value: 'mes'
      }
      ],
      tabelaSeparador: 'horizontal',
      colunasVisiveis: new BuscaMalote().setColunasVisiveisListagemMalotes(),
      tabelaColunas: new BuscaMalote().setTabelaColunasListagemMalotes()

    }
  },
  validations: {
    buscaMalote: {
      ano: {
        required: requiredIf(function () {
          return this.tipoConsulta !== 'documento'
        })
      },
      protocolo: {
        required: requiredIf(function () {
          return this.tipoConsulta === 'protocolo'
        })
      },
      mes: {
        required: requiredIf(function () {
          return this.tipoConsulta === 'mes'
        })
      }
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
    setOptionsAno (anos) {
      if (anos.length > 0) {
        const optionsAno = []
        anos.map(ano => optionsAno.push({
          label: `${ano.ano}`,
          value: `${ano.ano}`
        }))
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
      this.$router.push({
        name: 'alterarMalote',
        params: {
          id
        }
      })
    },
    procurar () {
      this.$v.buscaMalote.$touch()
      if (this.$v.buscaMalote.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.tipoConsulta === 'protocolo') {
          buscaMaloteService.seleciona(this.buscaMalote)
            .then(result => {
              tools.Loadings.hide()
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data.maloteDocumentos
              this.malote = result.data.malote

              tools.Notify.registrosEncontrados()
            })
        } else if (this.tipoConsulta === 'mes') {
          buscaMaloteService.procuraMes(this.buscaMalote)
            .then(result => {
              tools.Loadings.hide()
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data
              tools.Notify.registrosEncontrados()
            })
        } else if (this.tipoConsulta === 'documento') {
          buscaMaloteService.procuraDocumento(this.buscaMalote)
            .then(result => {
              tools.Loadings.hide()
              // this.listaDocumentos()
              console.log(result.data)
              this.registros = result.data
              tools.Notify.registrosEncontrados()
            })
        }
      }, 2000)
    },
    gerarRelatorio () {
      tools.Loadings.processando()
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        if (this.tipoConsulta === 'protocolo') {
          buscaMaloteService.relatorio(this.buscaMalote)
            .then(result => {
              tools.Loadings.hide()
              console.log('buscaMalote alterado com sucesso')
              // this.listaDocumentos()
              console.log(result.data)
              this.$store.commit('modalPdf/setModalPdf', {
                link: result.data.link,
                ativo: true
              })
              tools.Notify.registrosEncontrados()
            })
        } else if (this.tipoConsulta === 'mes') {
          buscaMaloteService.relatorioConsolidadoPorMes(this.buscaMalote)
            .then(result => {
              tools.Loadings.hide()
              console.log('buscaMalote alterado com sucesso')
              // this.listaDocumentos()
              this.$store.commit('modalPdf/setModalPdf', {
                link: result.data.link,
                ativo: true
              })
              tools.Notify.registrosEncontrados()
            })
        }
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
      const lista = []
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
