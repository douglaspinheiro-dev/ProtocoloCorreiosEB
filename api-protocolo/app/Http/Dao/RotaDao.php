<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class RotaDao extends Dao
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
      return DB::select("SELECT rota, codigo, descricao, usuarioCriador FROM rotas WHERE
      (codigo LIKE '%{$obj['busca']}%' OR
      descricao LIKE '%{$obj['busca']}%')
      AND ativo = 1 ORDER BY descricao LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT rota, codigo, descricao, usuarioCriador FROM rotas WHERE rota = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE rotas SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE rota = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO rotas (status, codigo, descricao, usuarioCriador) values ('{$dados['status']}','{$dados['codigo']}','{$dados['descricao']}', {$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE rotas SET codigo = '{$dados['codigo']}', descricao = '{$dados['descricao']}', usuarioAlterador = {$dados['usuarioAlterador']} where rota = {$dados['rota']}");
    }

    public static function options() {
      return DB::select("SELECT rota, codigo, descricao FROM rotas WHERE ativo = 1 order by descricao");
    }

    //
}
