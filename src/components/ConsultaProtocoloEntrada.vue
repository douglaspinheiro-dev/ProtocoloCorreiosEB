<template>
  <q-page class="q-pa-sm full-height">
    <form @submit.prevent="salvarAlterar">
      <div class="row barraBotoes">
        <div class="col-md-6 linhaBotoes">
          <q-btn small type="reset" @click="reset" icon="add" v-if="possoGravarProtocoloEntrada">Novo</q-btn>
          <q-btn small type="submit" icon="save" v-if="!protocoloEntrada.protocoloEntrada && possoGravarProtocoloEntrada">Gravar</q-btn>
        </div>
      </div>
      <q-list>
        <q-collapsible label="Consulta" opened>
          <div class="row">
            <div class="col-md-3">
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
            </div>
          </div>
        </q-collapsible>
      </q-list>
    </form>
    <br>
    <div>

      <q-table title="Lista de ProtocoloEntradas"
        :data="listaDeProtocoloEntradas"
        :columns="tabelaColunas"
        row-key="id"
        :loading="carregandoLista"
        :filter="buscaProtocoloEntrada"
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
            v-model="buscaProtocoloEntrada"
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
    </q-page-sticky>
  </q-page>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
var timer
import permissoes from 'src/services/permissoes/ValidaPermissoes'
import notify from 'src/tools/Notify'
import {mask} from 'vue-the-mask'
import ProtocoloEntrada from 'src/services/protocoloEntrada/ProtocoloEntrada'
import protocoloEntradaService from 'src/services/protocoloEntrada/ProtocoloEntradaService'

export default {
  name: 'Consulta Protocolo de Entrada',
  directives: {
    mask
  },
  data () {
    return {
      buscaProtocoloEntrada: '',
      optionsLoading: false,
      optionsSetor: [],
      optionsRotaEndereco: [],
      protocoloEntrada: new ProtocoloEntrada(),
      botaoSalvarAlterar: 'Salvar',
      carregandoLista: false,
      listaDeProtocoloEntradas: [],
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
    protocoloEntrada: {
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
          label: 'Sem registros cadastrados, confira o cadastro de Rotas',
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
      this.$v.protocoloEntrada.$reset()
      this.protocoloEntrada = new ProtocoloEntrada()
      this.protocoloEntrada.rota = this.rota
      this.botaoSalvarAlterar = 'Gravar'
    },
    carrega (id) {
      console.log('vou carregar o protocoloEntrada')
      this.$q.loading.show({
        message: 'Localizando o registro',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })

      protocoloEntradaService
        .seleciona(id)
        .then(result => {
          this.$q.loading.hide()
          console.log('peguei o protocoloEntrada com sucesso')
          this.protocoloEntrada = Object.assign({}, this.protocoloEntrada, result.data)
          this.botaoSalvarAlterar = 'Alterar'
        })
    },
    salvarAlterar () {
      this.protocoloEntrada.rota = this.rota
      this.$q.loading.show({
        message: 'Processando sua requisição',
        messageColor: 'white',
        spinnerSize: 250, // in pixels
        spinnerColor: 'white'
      })
      clearTimeout(timer)
      timer = setTimeout(() => {
        this.$v.protocoloEntrada.$touch()
        if (this.$v.protocoloEntrada.$error) {
          this.$q.loading.hide()
          this.$q.dialog({
            title: 'Atenção',
            message: 'Alguns campos precisam ser corrigidos.'
          }).then(() => { }).catch(() => { })
          return
        }
        if (this.protocoloEntrada.protocoloEntrada && this.possoAlterarProtocoloEntrada) {
          console.log('estou alterando o form')
          protocoloEntradaService.altera(this.protocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('protocoloEntrada alterado com sucesso')
              this.listaDocumentos()
              this.$q.notify({
                type: 'positive',
                message: 'Documento do malote alterado com sucesso.',
                timeout: 5000
              })
            })
        } else if (!this.protocoloEntrada.protocoloEntrada && this.possoGravarProtocoloEntrada) {
          this.protocoloEntrada.malote = this.malote
          protocoloEntradaService.grava(this.protocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('protocoloEntrada criado com sucesso')
              this.protocoloEntrada.protocoloEntrada = result.data.protocoloEntrada
              this.protocoloEntrada.usuarioCriador = result.data.usuarioCriador
              this.$q.notify({
                type: 'positive',
                message: 'Documento do malote criado com sucesso.',
                timeout: 5000
              })

              // limpando o form
              this.reset()
              this.preencheListaTabela(result.data.protocoloEntrada.lista)
            })
        } else {
          notify.semPermissao()
        }
      }, 2000)
    },
    excluir (id) {
      console.log(id)

      if (this.possoExcluirProtocoloEntrada) {
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

          protocoloEntradaService.apaga(this.protocoloEntrada.protocoloEntrada)
            .then(result => {
              this.$q.loading.hide()
              console.log('protocoloEntrada removido com sucesso')
              this.$q.notify({
                type: 'negative',
                message: 'ProtocoloEntrada removido com sucesso.',
                timeout: 5000
              })
              let idRegistro = this.listaDeProtocoloEntradas.filter(registro => registro.id === this.protocoloEntrada.protocoloEntrada)
              this.listaDeProtocoloEntradas.splice(this.listaDeProtocoloEntradas.indexOf(idRegistro[0]), 1)
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
      protocoloEntradaService
        .lista(this.malote)
        .then(result => {
          this.carregandoLista = false
          console.log('carreguei a lista de protocoloEntradas')
          this.preencheListaTabela(result.data.registros)
        })
    },
    preencheListaTabela (registros) {
      let lista = []
      registros.forEach(protocoloEntrada => {
        lista.push({
          id: protocoloEntrada.protocoloEntrada,
          tipoDocumento: protocoloEntrada.tipoDocumentoDescricao,
          numero: protocoloEntrada.numero,
          origem: protocoloEntrada.setorDescricao,
          destino: protocoloEntrada.codigoReduzido
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
    possoGravarProtocoloEntrada: () => permissoes.gravar('protocoloEntrada'),
    possoAbrirProtocoloEntrada: () => permissoes.abrir('protocoloEntrada'),
    possoExcluirProtocoloEntrada: () => permissoes.excluir('protocoloEntrada'),
    possoAlterarProtocoloEntrada: () => permissoes.alterar('protocoloEntrada')
  },
  mounted () {
    console.log('vou carregar a lista de protocoloEntrada')
    this.listaDocumentos()

    this.optionsLoading = true
    this.protocoloEntrada.malote = this.malote
    protocoloEntradaService.getOptions(this.rota)
      .then(result => {
        this.optionsLoading = false
        this.setOptionsRotaEndereco(result.data.rotaEndereco)
        this.setOptionsTipoDocumento(result.data.tipoDocumento)
        this.setOptionsSetor(result.data.setor)
      })
  }
}
</script>
