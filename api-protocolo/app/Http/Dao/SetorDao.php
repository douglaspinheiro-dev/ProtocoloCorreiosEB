<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class SetorDao extends Dao
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
      return DB::select("SELECT setor, descricao,codigoReduzido,usuarioCriador FROM setores WHERE
      (
        descricao LIKE '%{$obj['busca']}%' OR
        codigoReduzido LIKE '%{$obj['busca']}%' OR
        codigo LIKE '%{$obj['busca']}%'
      )
      AND ativo = 1 ORDER BY descricao LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT * FROM setores WHERE setor = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE setores SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE setor = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO setores
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
      return DB::update("UPDATE setores SET
      descricao = '{$dados['descricao']}',
      codigo = '{$dados['codigo']}',
      codigoReduzido = '{$dados['codigoReduzido']}',
      status = '{$dados['status']}',
      usuarioCriador = '{$dados['usuarioCriador']}'
      where setor = {$dados['setor']}");
    }

    //
}
