<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

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

    public static function seleciona($id) {
      return DB::select("SELECT
      protocoloEntrada,
      numero,
      dataDocumento,
      categoriaDocumento as tipoDocumento,
      origem,
      setor,
      assunto,
      usuarioCriador
      FROM protocoloEntradas WHERE protocoloEntrada = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE protocoloEntradas SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE protocoloEntrada = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO protocoloEntradas
      (
        numero,
        dataDocumento,
        categoriaDocumento,
        origem,
        setor,
        assunto,
        usuarioCriador
      ) values
      (
        '{$dados['numero']}',
        '{$dados['dataDocumento']}',
        '{$dados['tipoDocumento']}',
        '{$dados['origem']}',
        '{$dados['setor']}',
        '{$dados['assunto']}',
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
      usuarioCriador = '{$dados['usuarioCriador']}'
      where protocoloEntrada = {$dados['protocoloEntrada']}");
    }

    //
}
