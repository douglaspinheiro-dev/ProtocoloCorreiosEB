<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class TipoCobrancaDao extends Dao
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
      return DB::select("SELECT categoriaCobranca as tipoCobranca, descricao, valor, usuarioCriador FROM categoriasCobrancas WHERE
      descricao LIKE '%{$obj['busca']}%'
      AND ativo = 1 ORDER BY descricao LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT categoriaCobranca as tipoCobranca, descricao, valor, usuarioCriador FROM categoriasCobrancas WHERE categoriaCobranca = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE categoriasCobrancas SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE categoriaCobranca = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO categoriasCobrancas (descricao, status, valor, usuarioCriador) values ('{$dados['descricao']}', {$dados['status']}, {$dados['valor']}, {$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE categoriasCobrancas SET  descricao = '{$dados['descricao']}', status = '{$dados['status']}', valor = '{$dados['valor']}', usuarioAlterador = {$dados['usuarioAlterador']} where categoriaCobranca = {$dados['tipoCobranca']}");
    }

    //
}
