<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="salvarAlterar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarRotaEndereco">Novo</q-btn>
          <q-btn small type="submit" icon="save" v-if="!rotaEndereco.rotaEndereco && possoGravarRotaEndereco">Gravar</q-btn>
          <q-btn small type="submit" icon="save" v-if="rotaEndereco.rotaEndereco && possoAlterarRotaEndereco">Alterar</q-btn>
          <q-btn small type="button" icon="delete" @click="excluir" v-if="possoExcluirRotaEndereco">Excluir</q-btn>
        </div>
      </div>
      <q-list>
        <div class="row">
          <div class="col-md-12">
            <form-select
              classe="form-input"
              label="Endereço"
              hint="Obrigatório"
              :error="$v.rotaEndereco.endereco.$error"
              error-message="Obrigatório"
              v-model="rotaEndereco.endereco"
              :options="optionsEndereco"
              required
            />
            <q-linear-progress indeterminate v-show="optionsLoading"/>
          </div>
        </div>
      </q-list>
    </form>
    <br>
    <div>

      <q-table title="Lista de RotaEnderecos"
        :data="listaDeRotaEnderecos"
        :columns="tabelaColunas"
        row-key="id"
        :loading="carregandoLista"
        :filter="buscaRotaEndereco"
        :separator="tabelaSeparador"
        no-data-label="Sem registros encontrados"
        no-results-label="Sem registros encontrados"
        rows-per-page-label="Linhas por página"
        loading-label="Carregando"
        :visible-columns="colunasVisiveis"
      >
        <template slot="top-right" slot-scope="props">

          <q-select
            v-model="colunasVisiveis"
            multiple
            borderless
            dense
            options-dense
            display-value="Colunas"
            emit-value
            map-options
            :options="tabelaColunas"
            option-value="name"
            style="min-width: 150px"
          />
          <q-btn
            flat round dense
            :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen"
          />
        </template>
        <q-td slot="body-cell-remover" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round delete icon="delete" @click="excluir(props.row.id)" />
        </q-td>
      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>
  </q-page>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
let timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import { mask } from 'vue-the-mask'
import RotaEndereco from 'src/pages/cadastro/rota/RotaEndereco'
import rotaEnderecoService from 'src/pages/cadastro/rota/RotaEnderecoService'
import Endereco from 'src/pages/cadastro/endereco/Endereco'
import formSelect from 'src/components/form/select/QSelect'
import tools from 'src/tools'

export default {
  name: 'RotaEndereco',
  components: {
    formSelect
  },
  directives: {
    mask
  },
  data () {
    return {
      buscaRotaEndereco: '',
      optionsLoading: false,
      optionsEndereco: [],
      endereco: new Endereco(),
      rotaEndereco: new RotaEndereco(),
      botaoSalvarAlterar: 'Salvar',
      carregandoLista: false,
      listaDeRotaEnderecos: [],
      colunasVisiveis: [
        'codigo',
        'descricao',
        'logradouro',
        'uf'
      ],
      tabelaSeparador: 'horizontal',
      tabelaColunas: [
        {
          name: 'codigo',
          required: true,
          label: 'Código',
          align: 'left',
          field: 'codigo',
          sortable: true
        },
        {
          name: 'descricao',
          required: true,
          label: 'Descrição',
          align: 'left',
          field: 'descricao',
          sortable: true
        },
        {
          name: 'logradouro',
          label: 'Logradouro',
          align: 'left',
          field: 'logradouro',
          sortable: true
        },
        {
          name: 'numero',
          label: 'Número',
          align: 'left',
          field: 'numero'
        },
        {
          name: 'bairro',
          label: 'Bairro',
          align: 'left',
          field: 'bairro',
          sortable: true
        },
        {
          name: 'cidade',
          label: 'Cidade',
          align: 'left',
          field: 'cidade',
          sortable: true
        },
        {
          name: 'endereco',
          label: 'Endereço',
          align: 'left',
          field: 'endereco',
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
          name: 'uf',
          label: 'UF',
          align: 'left',
          field: 'uf',
          sortable: true
        },
        {
          name: 'remover',
          label: 'Remover',
          align: 'center',
          field: 'remover',
          required: true
        }
      ]
    }
  },
  validations: {
    rotaEndereco: {
      endereco: {
        required
      }
    }
  },
  methods: {
    reset () {
      this.$v.rotaEndereco.$reset()
      this.rotaEndereco = new RotaEndereco()
      this.rotaEndereco.rota = this.rota
      this.botaoSalvarAlterar = 'Gravar'
    },
    carrega (id) {
      console.log('vou carregar o rotaEndereco')
      tools.Loadings.processando()

      rotaEnderecoService
        .seleciona({ rotaEndereco: id, rota: this.rota })
        .then(result => {
          tools.Loadings.hide()
          console.log('peguei o rotaEndereco com sucesso')
          this.rotaEndereco = Object.assign({}, this.rotaEndereco, result.data)
          this.botaoSalvarAlterar = 'Alterar'
          this.confereExcluir()
        })
    },
    salvarAlterar () {
      this.rotaEndereco.rota = this.rota

      this.$v.rotaEndereco.$touch()
      if (this.$v.rotaEndereco.$invalid) return tools.Dialogs.formInvalido()
      tools.Loadings.processando()

      clearTimeout(timer)
      timer = setTimeout(() => {
        if (!this.rotaEndereco.rotaEndereco && this.possoGravarRotaEndereco) {
          rotaEnderecoService.grava(this.rotaEndereco)
            .then(result => {
              tools.Loadings.hide()
              console.log('rotaEndereco criado com sucesso')
              this.rotaEndereco.rotaEndereco = result.data.rotaEndereco
              this.rotaEndereco.usuarioCriador = result.data.usuarioCriador
              tools.Notify.positive('Endereço da Rota criado com sucesso.')

              const enderecoDescricao = this.optionsEndereco.filter(endereco => endereco.value === this.rotaEndereco.endereco)
              this.listaDeRotaEnderecos.push({
                id: this.rotaEndereco.rotaEndereco,
                endereco: enderecoDescricao
              })
              console.log(result.data)
              this.preencheListaTabela(result.data.rota.lista)
            })
        } else {
          tools.Notify.semPermissao()
        }
      }, 2000)
    },
    excluir (id) {
      console.log(id)

      if (this.possoExcluirRotaEndereco) {
        this.$q.dialog({
          title: 'Tem certeza?',
          message: 'Ao confirmar esta operação, não poderá desfazer.',
          ok: 'Sim, excluir',
          cancel: 'Cancelar'
        }).onOk(() => {
          tools.Loadings.processando()
          rotaEnderecoService.apaga({ rotaEndereco: id, rota: this.rota })
            .then(result => {
              tools.Loadings.hide()
              console.log('rotaEndereco removido com sucesso')
              tools.Notify.negative('Endereço da Rota removido com sucesso.')

              const idRegistro = this.listaDeRotaEnderecos.filter(registro => registro.id === id)
              this.listaDeRotaEnderecos.splice(this.listaDeRotaEnderecos.indexOf(idRegistro[0]), 1)
              this.reset()
            })
        })
      } else {
        tools.Notify.semPermissao()
      }
    },
    listaEnderecos (rota) {
      this.carregandoLista = true
      rotaEnderecoService
        .lista(rota)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de rotaEnderecos')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      const lista = []
      registros.forEach(rotaEndereco => {
        lista.push({
          id: rotaEndereco.rotaEndereco,
          codigo: rotaEndereco.codigo,
          descricao: rotaEndereco.descricao,
          logradouro: rotaEndereco.logradouro,
          cidade: rotaEndereco.cidade,
          cep: rotaEndereco.cep,
          uf: rotaEndereco.uf
        })
      })
      this.listaDeRotaEnderecos = lista
    }
  },
  props: [
    'rota'
  ],
  computed: {
    possoGravarRotaEndereco: () => permissoes.gravar('rotaEndereco'),
    possoAbrirRotaEndereco: () => permissoes.abrir('rotaEndereco'),
    possoExcluirRotaEndereco: () => permissoes.excluir('rotaEndereco')
  },
  mounted () {
    console.log('vou carregar a rotaEndereco')
    this.listaEnderecos(this.rota)

    this.optionsLoading = true
    rotaEnderecoService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.optionsEndereco = this.rotaEndereco.setOptions(result.data.endereco)
      })
  }
}
</script>
