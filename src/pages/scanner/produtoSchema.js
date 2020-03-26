import { print } from 'graphql'
import gql from 'graphql-tag'

const ProdutoSchema = {

  grava: print(gql`
    mutation produtoGravar($produto: ProdutoInput!) {
      data: produtoGravar(produto: $produto){
        produto
      }
    }
  `),
  seleciona: print(gql`
    query produtoSelecionar($produto: Int!) {
      data: produtoSelecionar(produto: $produto) {
        produto
        descricao
        codigo
        codigoDeBarras
        margemVenda
        estoqueMinimo
        estoqueIdeal
        foto
        quantidadeTotalCompra
        quantidadeTotalVenda
        quantidadeAtual
        quantidadeTotalConsumo
        precoVenda
        precoMedioCompra
        valorTotalCompra
        valorTotalVenda
        precoMedioVenda
        precoRecenteCompra
        precoRecenteVenda
        unidadeDeMedida
        _unidadeDeMedida{
          label: descricao
          value: unidadeDeMedida
        }
        tipoContabil
        grupoEstoque
        _grupoEstoque{
          label: descricao
          value: grupoEstoque
        }
        estoque
        _estoque{
          label: descricao
          value: estoque
        }
        tipoProduto
        _tipoProduto{
          label: descricao
          value: tipoProduto
        }
        subTipoProduto
        _subTipoProduto{
          label: descricao
          value: subTipoProduto
        }
        usuarioCriador
      }
    }
  `),
  altera: print(gql`
    mutation produtoAlterar($produto: ProdutoInput!) {
      data: produtoAlterar(produto: $produto)
    }
  `),

  exclui: print(gql`
    mutation produtoExcluir($id: Int!) {
      data: produtoExcluir( id: $id)
    }
  `),

  lista: print(gql`
    query {
      data: produtoListar {
        produto
        codigo
        descricao
      }
    }
  `),

  procura: print(gql`
    query produtoProcurar($busca: BuscaInput) {
      data: produtoProcurar(busca: $busca) {
        fim
        registros{
          produto
          codigo
          descricao
        }
      }
    }
  `),
  procuraSelect: print(gql`
    query produtoProcurar($busca: BuscaInput) {
      data: produtoProcurar(busca: $busca) {
        fim
        registros {
          value: produto
          label: descricao
        }
      }
    }
  `),
  getOptions: print(gql`
    {
      estoque: estoqueProcurar(busca: { busca: "", inicio:0, fim: 200 }){
        registros{
          value: estoque
          label: descricao
        }
      }
      grupoEstoque: grupoEstoqueProcurar(busca: { busca: "", inicio:0, fim: 200 }){
        registros{
          value: grupoEstoque
          label: descricao
        }
      }
      tipoProduto: tipoProdutoProcurar(busca: { busca: "", inicio:0, fim: 200 }){
        registros{
          value: tipoProduto
          label: descricao
        }
      }
      unidadeDeMedida: unidadeDeMedidaProcurar(busca: { busca: "", inicio:0, fim: 200 }){
        registros{
          value: unidadeDeMedida
          label: descricao
        }
      }
    }
  `)
}

export default ProdutoSchema
