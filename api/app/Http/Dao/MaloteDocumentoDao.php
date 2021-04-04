<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;
use App\ChromePhp;

class MaloteDocumentoDao extends Dao
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  public static function lista($id) {
    return DB::select("SELECT
      maloteDocumentos.*,
      maloteDocumentos.categoriaDocumento as tipoDocumento,
      enderecos.codigoReduzido,
      enderecos.descricao as enderecoDescricao,
      categoriasDocumentos.descricao as tipoDocumentoDescricao,
      setores.descricao as setorDescricao
  FROM maloteDocumentos
  JOIN enderecos ON enderecos.endereco = maloteDocumentos.rotaEndereco
  JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = maloteDocumentos.categoriaDocumento
  JOIN setores ON setores.setor = maloteDocumentos.setor
  AND maloteDocumentos.malote = '{$id}' ORDER BY maloteDocumentos.maloteDocumento desc");

  }

  public static function seleciona($id) {
    return DB::select("SELECT
      maloteDocumento,
      malote,
      categoriaDocumento as tipoDocumento,
      numero,
      setor,
      rotaEndereco
      FROM maloteDocumentos WHERE maloteDocumento = '{$id}'");
  }

  public static function apaga($id) {
    return DB::delete("DELETE FROM maloteDocumentos WHERE maloteDocumento = '{$id}'");
  }

  public static function salva($dados) {
    return DB::insert("INSERT INTO maloteDocumentos (malote, categoriaDocumento, numero, setor, rotaEndereco, usuarioCriador) values ('{$dados['malote']}','{$dados['tipoDocumento']}','{$dados['numero']}', '{$dados['setor']}','{$dados['rotaEndereco']}',{$dados['usuarioCriador']})");
  }

  public static function altera($dados) {
    return DB::update("UPDATE maloteDocumentos SET
      categoriaDocumento = '{$dados['tipoDocumento']}',
      numero = '{$dados['numero']}',
      setor = '{$dados['setor']}',
      rotaEndereco = '{$dados['rotaEndereco']}',
      usuarioAlterador = '{$dados['usuarioAlterador']}'
      WHERE maloteDocumento = {$dados['maloteDocumento']}");
  }

  public static function selecionaPorMaloteAnoProtocolo($dados) {
    return DB::select("SELECT * FROM malotesDocumentos WHERE malote = (select malote from malotes where anoCadastro = '2019' and protocolo = '1'");
  }

  public static function procuraDocumento($obj) {
      $sql = "SELECT
        maloteDocumentos.*,
        maloteDocumentos.categoriaDocumento as tipoDocumento,
        malotes.rota,
        DATE_FORMAT(malotes.data, '%d/%m/%Y') as data,
        malotes.protocolo,
        rotas.descricao as rotaDescricao,
        enderecos.codigoReduzido,
        enderecos.descricao as enderecoDescricao,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        setores.descricao as setorDescricao
      FROM maloteDocumentos
      JOIN malotes ON maloteDocumentos.malote = malotes.malote
      JOIN rotas ON malotes.rota = rotas.rota
      JOIN rotasEnderecos ON maloteDocumentos.rotaEndereco = rotasEnderecos.rotaEndereco
      JOIN enderecos ON enderecos.endereco = rotasEnderecos.endereco
      JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = maloteDocumentos.categoriaDocumento
      JOIN setores ON setores.setor = maloteDocumentos.setor
      AND
      (
        maloteDocumentos.categoriaDocumento LIKE '%{$obj['tipoDocumento']}%' AND
        maloteDocumentos.numero LIKE '%{$obj['numero']}%' AND
        maloteDocumentos.setor LIKE '%{$obj['setor']}%' AND
        maloteDocumentos.rotaEndereco LIKE '%{$obj['rotaEndereco']}%'
      )
      AND malotes.ativo = 1 ORDER BY maloteDocumentos.maloteDocumento desc";
    return DB::select($sql);
  }

  public static function procuraMes($obj) {
      $sql = "SELECT
        maloteDocumentos.*,
        maloteDocumentos.categoriaDocumento as tipoDocumento,
        malotes.rota,
        DATE_FORMAT(malotes.data, '%d/%m/%Y') as data,
        malotes.protocolo,
        rotas.descricao as rotaDescricao,
        enderecos.codigoReduzido,
        enderecos.descricao as enderecoDescricao,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        setores.descricao as setorDescricao,
        setores.codigo as setorCodigo
      FROM maloteDocumentos
      JOIN malotes ON maloteDocumentos.malote = malotes.malote
      JOIN rotas ON malotes.rota = rotas.rota
      JOIN enderecos ON maloteDocumentos.rotaEndereco = enderecos.endereco
      JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = maloteDocumentos.categoriaDocumento
      JOIN setores ON setores.setor = maloteDocumentos.setor
      AND
      (
        MONTH(malotes.data) = '{$obj['mes']}' AND
        YEAR(malotes.data) = '{$obj['ano']}'
      )
      AND malotes.ativo = 1 ORDER BY malotes.data, maloteDocumentos.maloteDocumento desc";

    return DB::select($sql);
  }
}
