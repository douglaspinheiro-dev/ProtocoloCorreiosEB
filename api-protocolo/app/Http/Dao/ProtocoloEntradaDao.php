<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;
use App\ChromePhp;

class ProtocoloEntradaDao extends Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public static function lista($obj) {
      return DB::select("SELECT
        protocoloEntrada,
        protocolo,
        anoCadastro,
        numero,
        assunto,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        DATE_FORMAT(dataDocumento, '%d/%m/%Y') as dataDocumento,
        origem,
        setores.codigo as setorDescricao
        FROM protocoloEntradas
        JOIN categoriasDocumentos on protocoloEntradas.categoriaDocumento = categoriasDocumentos.categoriaDocumento
        JOIN setores on protocoloEntradas.setor = setores.setor
        AND
      (
        protocoloEntradas.numero LIKE '%{$obj['busca']}%' OR
        protocoloEntradas.protocoloEntrada LIKE '%{$obj['busca']}%'
      )
      AND protocoloEntradas.ativo = 1 ORDER BY protocoloEntradas.dataDocumento desc LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function procura($obj) {
      return DB::select("SELECT
        protocoloEntrada,
        protocolo,
        anoCadastro,
        numero,
        assunto,
        categoriasDocumentos.codigo as tipoDocumentoDescricao,
        DATE_FORMAT(dataDocumento, '%d/%m/%Y') as dataDocumento,
        origem,
        setores.codigo as setorDescricao
        FROM protocoloEntradas
        JOIN categoriasDocumentos on protocoloEntradas.categoriaDocumento = categoriasDocumentos.categoriaDocumento
        JOIN setores on protocoloEntradas.setor = setores.setor
        AND
      (
        protocoloEntradas.numero LIKE '%{$obj['busca']}%' OR
        protocoloEntradas.protocoloEntrada LIKE '%{$obj['busca']}%'
      )
      AND protocoloEntradas.ativo = 1 ORDER BY protocoloEntradas.dataDocumento desc LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT *, categoriaDocumento as tipoDocumento FROM protocoloEntradas WHERE protocoloEntrada = '{$id}' AND ativo = 1");
    }

    public static function selecionaPorAno($dados) {
      return DB::select("
      SELECT
        protocoloEntradas.protocolo,
        protocoloEntradas.protocoloEntrada,
        protocoloEntradas.numero,
        DATE_FORMAT(protocoloEntradas.dataDocumento, '%d/%m/%Y') as dataDocumento,
        protocoloEntradas.origem,
        protocoloEntradas.assunto,
        categoriasDocumentos.descricao as tipoDocumento,
        setores.descricao as destino
      FROM protocoloEntradas
      JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = protocoloEntradas.categoriaDocumento
      JOIN setores ON setores.setor = protocoloEntradas.setor
      AND protocoloEntradas.protocolo = '{$dados['id']}'
      AND protocoloEntradas.anoCadastro = '{$dados['ano']}'
      AND protocoloEntradas.ativo = 1;");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE protocoloEntradas SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE protocoloEntrada = '{$dados['id']}'");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO protocoloEntradas
      (
        protocoloEntrada,
        anoCadastro,
        numero,
        dataDocumento,
        categoriaDocumento,
        origem,
        setor,
        assunto,
        enderecoCadastrado,
        usuarioCriador
      ) values
      (
        '{$dados['protocoloEntrada']}',
        '{$dados['anoCadastro']}',
        '{$dados['numero']}',
        '{$dados['dataDocumento']}',
        '{$dados['tipoDocumento']}',
        '{$dados['origem']}',
        '{$dados['setor']}',
        '{$dados['assunto']}',
        '{$dados['enderecoCadastrado']}',
        '{$dados['usuarioCriador']}'
      )");
    }

    public static function altera($dados) {
      return DB::update("UPDATE protocoloEntradas SET
      numero = '{$dados['numero']}',
      dataDocumento = '{$dados['dataDocumento']}',
      categoriaDocumento = '{$dados['tipoDocumento']}',
      origem = '{$dados['origem']}',
      setor = '{$dados['setor']}',
      assunto = '{$dados['assunto']}',
      enderecoCadastrado = '{$dados['enderecoCadastrado']}',
      usuarioAlterador = '{$dados['usuarioAlterador']}'
      where protocoloEntrada = '{$dados['protocoloEntrada']}'");
    }

    public static function listaAnos() {
      return DB::select("select anoCadastro as ano from protocoloEntradas group by ano order by  ano desc");
    }

    public static function procuraDocumento($obj) {

      return DB::select("
        SELECT
          protocoloEntradas.protocolo,
          protocoloEntradas.protocoloEntrada,
          protocoloEntradas.numero,
          DATE_FORMAT(protocoloEntradas.dataDocumento, '%d/%m/%Y') as dataDocumento,
          DATE_FORMAT(protocoloEntradas.dataCadastro, '%d/%m/%Y') as dataCadastro,
          protocoloEntradas.origem,
          protocoloEntradas.assunto,
          categoriasDocumentos.codigo as tipoDocumento,
          setores.descricao as destino
        FROM protocoloEntradas
        JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = protocoloEntradas.categoriaDocumento
        JOIN setores ON setores.setor = protocoloEntradas.setor
        AND
        (
          protocoloEntradas.numero LIKE '%{$obj['numero']}%' AND
          {$obj['consultaData']}
          protocoloEntradas.assunto LIKE '%{$obj['assunto']}%' AND
          protocoloEntradas.origem LIKE '%{$obj['origem']}%' AND
          protocoloEntradas.setor LIKE '%{$obj['setor']}%'
        )
        AND protocoloEntradas.ativo = 1 ORDER BY protocoloEntradas.dataDocumento desc LIMIT 1000
        ");
    }

    //
}
