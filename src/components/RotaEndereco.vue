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
        <q-collapsible label="Enderecos" opened>
          <div>
            <div class="row">
              <div class="col-md-12">
                <q-field class="form-input"
                  label="Endereço"
                  orientation="vertical"
                  helper="Obrigatório"
                  :error="$v.rotaEndereco.endereco.$error"
                  error-label="Obrigatório"
                >
                  <q-select
                    v-model="rotaEndereco.endereco"
                    :options="optionsEndereco"
                    filter
                    autofocus-filter
                    filter-placeholder="Selecione a Origem"
                    name="select"
                    @input="$v.rotaEndereco.endereco.$touch()"
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
        <template slot="top-left" slot-scope="props">
          <q-search
            placeholder="Busca"
            hide-underline
            color="secondary"
            v-model="buscaRotaEndereco"
            class="col-6"
          />
        </template>
        <template slot="top-right" slot-scope="props">
          <q-table-columns
            label="Colunas"
            color="secondary"
            class="q-mr-sm"
            v-model="colunasVisiveis"
            :columns="tabelaColunas"
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
        <q-td slot="body-cell-remover" slot-scope="props" :props="props">
          <q-btn type="button" color="primary" flat round delete icon="delete" @click="excluir(props.row.id)" />
        </q-td>
      </q-table>
      <!-- <q-inner-loading :visible="carregandoLista">
        <q-spinner-gears size="50px" color="primary"></q-spinner-gears>
      </q-inner-loading> -->
    </div>

    <q-page-sticky position="bottom-right" :offset="[18, 18]" v-if="
      possoGravarRotaEndereco ||
      possoExcluirRotaEndereco
    ">
      <q-fab color="primary" active-icon="close" direction="up" icon="expand less">
        <q-tooltip slot="tooltip" anchor="center left" self="center right" :offset="[20, 0]">
          Botões de ação
        </q-tooltip>
        <q-fab-action color="positive" icon="save" @click="salvarAlterar" v-if="possoGravarRotaEndereco || possoAlterarRotaEndereco">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">{{ botaoSalvarAlterar }}</q-tooltip>
        </q-fab-action>
        <q-fab-action color="secondary" type="reset" @click="reset" icon="add" v-if="possoGravarRotaEndereco">
          <q-tooltip anchor="center left" self="center right" :offset="[20, 0]">Novo</q-tooltip>
        </q-fab-action>
        <q-fab-action color="negative" type="button" @click="excluir" icon="delete" v-if="possoExcluirRotaEndereco">
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
import RotaEndereco from 'src/services/rotaEndereco/RotaEndereco'
import rotaEnderecoService from 'src/services/rotaEndereco/RotaEnderecoService'

export default {
  name: 'RotaEndereco',
  directives: {
    mask
  },
  data () {
    return {
      buscaRotaEndereco: '',
      optionsLoading: false,
      optionsEndereco: [],
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
    setOptionsEndereco (enderecos) {
      if (enderecos.length > 0) {
        let optionsEndereco = []
        enderecos.map(endereco => optionsEndereco.push(
          {
            label: `${endereco.codigoReduzido} - ${endereco.descricao}`,
            value: endereco.endereco
          }
        ))
        this.optionsEndereco = optionsEndereco
      } else {
        this.optionsEndereco = [{
          label: 'Sem registros cadastrados',
          value: ''
        }]
      }
    },
    reset () {
      this.$v.rotaEndereco.$reset()
      this.rotaEndereco = new RotaEndereco()
      this.rotaEndereco.rota = this.rota
      this.botaoSalvarAlterar = 'Gravar'
    },
    carrega (id) {
      console.log('vou carregar o rotaEndereco')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      rotaEnderecoService
        .seleciona({rotaEndereco: id, rota: this.rota})
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o rotaEndereco com sucesso')
          this.rotaEndereco = Object.assign({}, this.rotaEndereco, result.data)
          this.botaoSalvarAlterar = 'Alterar'
          this.confereExcluir()
        })
    },
    salvarAlterar () {
      this.rotaEndereco.rota = this.rota
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(timer)
      timer = setTimeout(() => {
        this.$v.rotaEndereco.$touch()
        if (this.$v.rotaEndereco.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }
        if (!this.rotaEndereco.rotaEndereco && this.possoGravarRotaEndereco) {
          rotaEnderecoService.grava(this.rotaEndereco)
            .then(result => {
              this.$q.loading.hide()
              console.log('rotaEndereco criado com sucesso')
              this.rotaEndereco.rotaEndereco = result.data.rotaEndereco
              this.rotaEndereco.usuarioCriador = result.data.usuarioCriador
              this.$q.notify({
                type: 'positive',
                message: 'RotaEndereco criado com sucesso.',
                timeout: 5000
              })

              let enderecoDescricao = this.optionsEndereco.filter(endereco => endereco.value === this.rotaEndereco.endereco)
              this.listaDeRotaEnderecos.push({
                id: this.rotaEndereco.rotaEndereco,
                endereco: enderecoDescricao
              })
              console.log(result.data)
              this.preencheListaTabela(result.data.rota.lista)
            })
        } else {
          notify.semPermissao()
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
        }).then(() => {
          this.$q.loading.show({
            message: 'Processando sua requisição',
            messageColor: 'white',
            spinnerSize: 250, // in pixels
            spinnerColor: 'white'
          })

          rotaEnderecoService.apaga({rotaEndereco: id, rota: this.rota})
            .then(result => {
              this.$q.loading.hide()
              console.log('rotaEndereco removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'RotaEndereco removido com sucesso.',
                timeout: 5000
              })
              let idRegistro = this.listaDeRotaEnderecos.filter(registro => registro.id === id)
              this.listaDeRotaEnderecos.splice(this.listaDeRotaEnderecos.indexOf(idRegistro[0]), 1)
              this.reset()
            })
        }).catch(() => {
          // Picked "Cancel" or dismissed
        })
      } else {
        notify.semPermissao()
      }
    },
    listaEnderecos () {
      this.carregandoLista = true
      rotaEnderecoService
        .lista(this.rota)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de rotaEnderecos')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
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
    this.listaEnderecos()

    this.optionsLoading = true
    rotaEnderecoService.getOptions()
      .then(result => {
        this.optionsLoading = false
        this.setOptionsEndereco(result.data.endereco)
      })
  }
}
</script>
