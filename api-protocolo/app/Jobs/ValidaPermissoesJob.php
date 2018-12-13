<?php

namespace App\Jobs;
use App\Http\Dao\PermissoesModuloDao;
use Illuminate\Http\Request;
use App\ChromePhp;

class ValidaPermissoesJob extends Job
{
  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->usuario = $this->$request->auth['0']->usuario;
  }

  public function abrir($dados)
  {
    return $results = PermissoesModuloDao::confereAbrir([
      'modulo' => $dados['modulo'],
      'usuario' => $this->usuario,
    ]);
  }

  public function inserir($dados)
  {
    return $results = PermissoesModuloDao::confereInserir([
      'modulo' => $dados['modulo'],
      'usuario' => $this->usuario,
    ]);
  }

  public function alterar($dados)
  {
    return $results = PermissoesModuloDao::confereAlterar([
      'modulo' => $dados['modulo'],
      'usuario' => $this->usuario,
    ]);
  }

  public function excluir($dados)
  {
    return $results = PermissoesModuloDao::confereExcluir([
      'modulo' => $dados['modulo'],
      'usuario' => $this->usuario,
    ]);
  }

}
