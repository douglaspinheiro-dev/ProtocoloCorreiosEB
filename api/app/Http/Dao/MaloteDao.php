<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;
use App\ChromePhp;

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
        malotes.protocolo,
        malotes.lacre,
        DATE_FORMAT(malotes.data, '%d/%m/%Y') as data,
        malotes.rota,
        malotes.usuarioCriador,
        rotas.descricao as rotaDescricao
      FROM malotes
      JOIN rotas on rotas.rota = malotes.rota AND
    (malotes.protocolo LIKE '%{$obj['busca']}%' OR
    DATE_FORMAT(malotes.data, '%d/%m/%Y') LIKE '%{$obj['busca']}%')
    AND malotes.ativo = 1 ORDER BY malotes.data desc LIMIT {$obj['inicio']}, {$obj['fim']}");
  }

  public static function seleciona($id) {
    return DB::select("SELECT malotes.* , rotas.descricao as rotaDescricao FROM malotes
    JOIN rotas ON rotas.rota = malotes.rota
    AND malotes.malote = '{$id}' AND malotes.ativo = 1");
  }

  public static function apaga($dados) {
    return DB::update("UPDATE malotes SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE malote = '{$dados['id']}'");
  }

  public static function salva($dados) {
    return DB::insert("INSERT INTO malotes (
      malote,
      anoCadastro,
      data,
      rota,
      lacre,
      numeroBolsa,
      usuarioCriador
    ) values (
      '{$dados['malote']}',
      '{$dados['anoCadastro']}',
      '{$dados['data']}',
      '{$dados['rota']}',
      '{$dados['lacre']}',
      '{$dados['numeroBolsa']}',
      '{$dados['usuarioCriador']}')"
    );
  }

  public static function altera($dados) {
    return DB::update("UPDATE malotes SET
      lacre = '{$dados['lacre']}',
      numeroBolsa = '{$dados['numeroBolsa']}',
      data = '{$dados['data']}',
      usuarioAlterador = {$dados['usuarioAlterador']},
      rota = {$dados['rota']}
    where malote = '{$dados['malote']}'");
  }

  public static function options() {
    return DB::select("SELECT malote, codigo, descricao FROM malotes WHERE ativo = 1 order by descricao");
  }

  public static function listaAnos() {
    return DB::select("SELECT anoCadastro as ano from malotes group by ano desc");
  }

  public static function selecionaPorAno($dados) {
    return DB::select("
    SELECT
      malotes.protocolo,
      malotes.malote,
      malotes.lacre,
      malotes.numeroBolsa,
      DATE_FORMAT(malotes.data, '%d/%m/%Y') as data,
      rotas.descricao as rotaDescricao
    FROM malotes
    JOIN rotas ON rotas.rota = malotes.rota
    AND malotes.protocolo = '{$dados['protocolo']}'
    AND malotes.anoCadastro = '{$dados['ano']}'
    AND malotes.ativo = 1;");
  }


  //
}
