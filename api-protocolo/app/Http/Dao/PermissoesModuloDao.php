<?php

namespace App\Http\Dao;
use Illuminate\Support\Facades\DB;
use App\ChromePhp;


class PermissoesModuloDao
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
  public static function salva($permissoes) {

    $query = '';
    foreach ($permissoes as $permissao) {
      # code...
      $query = $query."({$permissao['abrir']}, {$permissao['inserir']}, {$permissao['alterar']}, {$permissao['excluir']}, (SELECT modulo from modulos WHERE nomeHtml = '{$permissao['nomeHtml']}'), {$permissao['categoriaUsuario']}),";
    };
    $query = substr($query, 0, -1);
    return DB::insert("INSERT INTO permissoesModulos (abrir, inserir, alterar, excluir, modulo, categoriaUsuario) VALUES {$query}");
  }

  public static function lista($id) {
    return DB::select("SELECT permissoesModulos.*, modulos.nomeHtml FROM permissoesModulos join modulos on modulos.modulo = permissoesModulos.modulo and permissoesModulos.categoriaUsuario = {$id}");
  }

  public static function apaga($id) {
    return DB::update("DELETE from permissoesModulos where categoriaUsuario = {$id}");
  }

  public static function verificaPermissoes($dados) {
    return DB::select("SELECT permissoesModulos.* from permissoesModulos
     JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '${dados.modulo}'
     join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo
      and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");
  }

  public static function confereAbrir($dados) {
    ChromePhp::log("SELECT permissoesModulos.abrir from permissoesModulos JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '{$dados['modulo']}' join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");

    return DB::select("SELECT permissoesModulos.abrir from permissoesModulos JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '{$dados['modulo']}' join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");
  }

  public static function confereInserir($dados) {
    return DB::select("SELECT permissoesModulos.inserir from permissoesModulos JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '{$dados['modulo']}' join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");
  }

  public static function confereAlterar($dados) {
    return DB::select("SELECT permissoesModulos.alterar from permissoesModulos JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '{$dados['modulo']}' join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");
  }

  public static function confereExcluir($dados) {
    return DB::select("SELECT permissoesModulos.excluir from permissoesModulos JOIN modulos on modulos.modulo = permissoesModulos.modulo and modulos.nomeHtml = '{$dados['modulo']}' join categoriasModulos on categoriasModulos.categoriaModulo = modulos.categoriaModulo and categoriaUsuario = (select categoriaUsuario from usuarios where usuario = '{$dados['usuario']}')");
  }

}
