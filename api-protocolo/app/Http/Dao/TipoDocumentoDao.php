<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class TipoDocumentoDao extends Dao
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
      return DB::select("SELECT categoriaDocumento as tipoDocumento, codigo, descricao, usuarioCriador FROM categoriasDocumentos WHERE
      (codigo LIKE '%{$obj['busca']}%' OR
      descricao LIKE '%{$obj['busca']}%')
      AND ativo = 1 ORDER BY descricao LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT categoriaDocumento as tipoDocumento, codigo, descricao, usuarioCriador FROM categoriasDocumentos WHERE categoriaDocumento = {$id} AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE categoriasDocumentos SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE categoriaDocumento = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO categoriasDocumentos (categoriaDocumento, codigo, descricao, usuarioCriador) values ('{$dados['tipoDocumento']}','{$dados['codigo']}',{$dados['descricao']}, {$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE categoriasDocumentos SET codigo = '{$dados['codigo']}', descricao = '{$dados['descricao']}', usuarioAlterador = {$dados['usuarioAlterador']} where categoriaDocumento = {$dados['tipoDocumento']}");
    }

    public static function options() {
      return DB::select("SELECT categoriaDocumento as tipoDocumento, codigo, descricao FROM categoriasDocumentos WHERE ativo = 1 order by descricao");
    }

    //
}
