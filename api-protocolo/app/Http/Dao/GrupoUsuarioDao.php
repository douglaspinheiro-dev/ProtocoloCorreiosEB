<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class GrupoUsuarioDao extends Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function lista() {
      return DB::select("SELECT categoriaUsuario as grupoUsuario, codigo, descricao FROM categoriasUsuarios WHERE ativo = 1 ORDER BY descricao");
    }

    public static function seleciona($id) {
      return DB::select("SELECT categoriaUsuario as grupoUsuario, codigo, descricao FROM categoriasUsuarios WHERE categoriaUsuario = {$id} AND ativo = 1");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO categoriasUsuarios (codigo, descricao, usuarioCriador) values ('{$dados['codigo']}','{$dados['descricao']}', {$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE categoriasUsuarios SET codigo = '{$dados['codigo']}', descricao = '{$dados['descricao']}', usuarioAlterador = {$dados['usuarioAlterador']} where categoriaUsuario = {$dados['grupoUsuario']}");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE categoriasUsuarios SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE categoriaUsuario = {$dados['grupoUsuario']}");
    }

    public static function buscaPorId($id) {
      return DB::select("SELECT
        permissoesModulos.*,
        modulos.nomeHtml,
        categoriasModulos.*,
        categoriasUsuarios.categoriaUsuario,
        categoriasUsuarios.codigo,
        categoriasUsuarios.descricao,
        categoriasUsuarios.usuarioCriador
      from permissoesModulos
      JOIN modulos on modulos.modulo = permissoesModulos.modulo
      join categoriasUsuarios on permissoesModulos.categoriaUsuario = categoriasUsuarios.categoriaUsuario and categoriasUsuarios.ativo = 1
      join categoriasModulos on categoriasModulos.categoriamodulo = modulos.categoriamodulo and permissoesModulos.categoriaUsuario = {$id}");
    }

    //
}
