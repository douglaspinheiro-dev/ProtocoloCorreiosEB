<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class MaloteDao extends Dao
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
          malotes.malote,
          malotes.lacre,
          DATE_FORMAT(malotes.data, '%d/%m/%Y') as data,
          malotes.rota,
          malotes.usuarioCriador,
          rotas.descricao
        FROM malotes
        JOIN rotas on rotas.rota = malotes.rota AND
      (malotes.malote LIKE '%{$obj['busca']}%' OR
      DATE_FORMAT(malotes.data, '%d/%m/%Y') LIKE '%{$obj['busca']}%')
      AND malotes.ativo = 1 ORDER BY malotes.data LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT * FROM malotes WHERE malote = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE malotes SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE malote = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO malotes (data, rota, lacre, numeroBolsa, usuarioCriador) values ('{$dados['data']}','{$dados['rota']}','{$dados['lacre']}','{$dados['numeroBolsa']}', {$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE malotes SET codigo = '{$dados['codigo']}', descricao = '{$dados['descricao']}', usuarioAlterador = {$dados['usuarioAlterador']} where malote = {$dados['malote']}");
    }

    public static function options() {
      return DB::select("SELECT malote, codigo, descricao FROM malotes WHERE ativo = 1 order by descricao");
    }

    //
}
