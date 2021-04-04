<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioDao extends Dao
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  public static function lista($obj)
  {
    return DB::select("SELECT usuario, nome, login FROM usuarios WHERE
      (nome LIKE '%{$obj['busca']}%' OR
      login LIKE '%{$obj['busca']}%')
      AND ativo = 1 ORDER BY login LIMIT {$obj['inicio']}, {$obj['fim']}");
  }

  public static function seleciona($id)
  {
    return DB::select("SELECT usuario,nome,login, categoriaUsuario as grupoUsuario, usuarioCriador FROM usuarios WHERE usuario = '{$id}' AND ativo = 1");
  }

  public static function apaga($dados)
  {
    return DB::update("UPDATE usuarios SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE usuario = {$dados['id']}");
  }

  public static function alteraSenha($dados)
  {
    // $dados['password'] = Hash::make($dados['password']);
    return DB::update("UPDATE usuarios SET password = '{$dados['password']}', usuarioAlterador = {$dados['usuarioAlterador']}, primeiroLogin = 0 WHERE usuario = {$dados['id']}");
  }

  public static function salva($dados)
  {
    return DB::insert("INSERT INTO usuarios (nome, login, categoriaUsuario, usuarioCriador) values ('{$dados['nome']}','{$dados['login']}',{$dados['grupoUsuario']}, {$dados['usuarioCriador']})");
  }

  public static function altera($dados)
  {
    return DB::update("UPDATE usuarios SET nome = '{$dados['nome']}', login = '{$dados['login']}', categoriaUsuario = {$dados['grupoUsuario']}, usuarioAlterador = {$dados['usuarioAlterador']} where usuario = {$dados['usuario']}");
  }

    //
}
