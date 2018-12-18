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
      return DB::select("SELECT protocoloEntrada, numero, assunto, dataDocumento, origem, destino, usuarioCriador FROM protocoloEntradas WHERE
      (
        dataDocumento LIKE '%{$obj['busca']}%' OR
        numero LIKE '%{$obj['busca']}%' OR
        assunto LIKE '%{$obj['busca']}%' OR
        origem LIKE '%{$obj['busca']}%' OR
        destino LIKE '%{$obj['busca']}%'
      )
      AND ativo = 1 ORDER BY dataDocumento LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT * FROM protocoloEntradas WHERE protocoloEntrada = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE protocoloEntradas SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE protocoloEntrada = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO protocoloEntradas
      (
        descricao,
        codigo,
        codigoReduzido,
        status,
        usuarioCriador
      ) values
      (
        '{$dados['descricao']}',
        '{$dados['codigo']}',
        '{$dados['codigoReduzido']}',
        '{$dados['status']}',
        '{$dados['usuarioCriador']}'
      )");
    }

    public static function altera($dados) {
      return DB::update("UPDATE protocoloEntradas SET
      descricao = '{$dados['descricao']}',
      codigo = '{$dados['codigo']}',
      codigoReduzido = '{$dados['codigoReduzido']}',
      status = '{$dados['status']}',
      usuarioCriador = '{$dados['usuarioCriador']}'
      where protocoloEntrada = {$dados['protocoloEntrada']}");
    }

    //
}
