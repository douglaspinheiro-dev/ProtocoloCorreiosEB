import dayjs from 'dayjs'

export default class BuscaCorrespondencia {
  constructor (obj = {}) {
    this.ano = obj.ano || dayjs().format('YYYY')
    this.destino = obj.destino || ''
    this.setor = obj.setor || ''
    this.numero = obj.numero || ''
    this.cep = obj.cep || ''
    this.estado = obj.estado || ''
    this.tipoDocumento = obj.tipoDocumento || ''
    this.tipoCobranca = obj.tipoCobranca || ''
    this.tipoCorrespondencia = obj.tipoCorrespondencia || ''
    this.codigoRastreio = obj.codigoRastreio || ''
    this.dataCadastro = obj.dataCadastro || dayjs().format('YYYY-MM-DD')
    this.tipoData = obj.tipoData || 'periodo'
    this.dataInicial = obj.dataInicial || dayjs().startOf('month').format('YYYY-MM-DD')
    this.dataFinal = obj.dataFinal || dayjs().endOf('month').format('YYYY-MM-DD')
    this.mesCadastro = obj.mesCadastro || dayjs().format('YYYY-MM')
    this.protocolo = obj.protocolo || ''
    this.tipoRelatorio = obj.tipoRelatorio || 'listagemDeCorrespondencia'
  }

  setTabelaColunasListagemCorrespondencias () {
    return [
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
        name: 'numeroDocumento',
        label: 'Nº',
        align: 'left',
        field: 'numeroDocumento'
      },
      {
        name: 'origem',
        label: 'Origem - Remetente',
        align: 'left',
        field: 'origemRemetente',
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
        name: 'logradouro',
        label: 'Endereco',
        align: 'left',
        field: 'logradouro',
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
        name: 'cep',
        label: 'CEP',
        align: 'left',
        field: 'cep',
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
        name: 'tipoCorrespondencia',
        label: 'Tipo de Cor.',
        align: 'left',
        field: 'tipoCorrespondencia',
        sortable: true
      },
      {
        name: 'valorTotal',
        label: 'R$',
        align: 'left',
        field: 'valorTotal',
        sortable: true
      },
      {
        name: 'editar',
        label: 'Editar',
        align: 'center',
        field: 'correspondencia',
        required: true
      }
    ]
  }

  setTabelaColunasControleDeRegistroDePostagem () {
    return [
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
      },
      {
        name: 'editar',
        label: 'Editar',
        align: 'center',
        field: 'correspondencia',
        required: true
      }
    ]
  }

  setColunasVisiveisControleDeRegistroDePostagem () {
    return [
      'origem',
      'tipoCorrespondencia',
      'cep',
      'codigoRastreio',
      'tipoDocumento',
      'numeroDocumento'
    ]
  }

  setColunasVisiveisListagemCorrespondencias () {
    return ['numeroDocumento', 'tipoDocumento', 'numero', 'origem', 'destino', 'cep', 'tipoCorrespondencia', 'valorTotal', 'dataCadastro']
  }
}
