import dayjs from 'dayjs'

export default class BuscaMalote {
  constructor (obj = {}) {
    this.ano = obj.ano || ''
    this.destino = obj.destino || ''
    this.setor = obj.setor || ''
    this.numero = obj.numero || ''
    this.lacre = obj.lacre || ''
    this.bolsa = obj.bolsa || ''
    this.rota = obj.rota || ''
    this.rotaEndereco = obj.rotaEndereco || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.dataCadastro = obj.dataCadastro || dayjs().format('YYYY-MM-DD')
    this.tipoData = obj.tipoData || 'periodo'
    this.dataInicial = obj.dataInicial || dayjs().startOf('month').format('YYYY-MM-DD')
    this.dataFinal = obj.dataFinal || dayjs().endOf('month').format('YYYY-MM-DD')
    this.mesCadastro = obj.mesCadastro || dayjs().format('YYYY-MM')
    this.protocolo = obj.protocolo || ''
    this.tipoRelatorio = obj.tipoRelatorio || 'listagemDeMalote'
  }

  setTabelaColunasListagemMalotes () {
    return [
      {
        name: 'tipoDocumentoDescricao',
        required: true,
        label: 'Tipo Doc.',
        align: 'left',
        field: 'tipoDocumentoDescricao',
        sortable: true
      },
      {
        name: 'numero',
        label: 'Nº',
        align: 'left',
        field: 'numero'
      },
      {
        name: 'setorDescricao',
        label: 'Setor',
        align: 'left',
        field: 'setorDescricao',
        sortable: true
      },
      {
        name: 'enderecoDescricao',
        label: 'Destino',
        align: 'left',
        field: 'enderecoDescricao',
        sortable: true
      },
      {
        name: 'editar',
        label: 'Editar',
        align: 'center',
        field: 'maloteDocumento',
        required: true
      }
    ]
  }

  setColunasVisiveisListagemMalotes () {
    return ['numero', 'tipoDocumentoDescricao', 'setorDescricao', 'enderecoDescricao']
  }

  setTabelaColunasDocumentosMalotes () {
    return [
      {
        name: 'tipoDocumentoDescricao',
        required: true,
        label: 'Tipo Doc.',
        align: 'left',
        field: 'tipoDocumentoDescricao',
        sortable: true
      },
      {
        name: 'numero',
        label: 'Nº',
        align: 'left',
        field: 'numero'
      },
      {
        name: 'setorDescricao',
        label: 'Setor',
        align: 'left',
        field: 'setorDescricao',
        sortable: true
      },
      {
        name: 'enderecoDescricao',
        label: 'Destino',
        align: 'left',
        field: 'enderecoDescricao',
        sortable: true
      },
      {
        name: 'protocolo',
        label: 'Malote',
        align: 'left',
        field: 'protocolo',
        sortable: true
      },
      {
        name: 'rotaDescricao',
        label: 'Rota',
        align: 'left',
        field: 'rotaDescricao',
        sortable: true
      },
      {
        name: 'data',
        label: 'Data',
        align: 'left',
        field: 'data',
        sortable: true
      },
      {
        name: 'editar',
        label: 'Editar',
        align: 'center',
        field: 'maloteDocumento',
        required: true
      }
    ]
  }

  setColunasVisiveisDocumentosMalotes () {
    return ['numero', 'tipoDocumentoDescricao', 'setorDescricao', 'enderecoDescricao', 'protocolo', 'rotaDescricao', 'data']
  }
}
