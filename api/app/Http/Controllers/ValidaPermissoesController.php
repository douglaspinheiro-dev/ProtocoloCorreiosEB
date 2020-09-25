<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Dao\PermissoesModuloDao;
use App\ChromePhp;

class ValidaPermissoesController extends Controller
{

  public function abrir($dados)
  {
    return $results = PermissoesModuloDao::confereAbrir([
      'modulo' => $dados,
      'usuario' => $this->getUsuario(),
    ])[0]->abrir;
  }

  public function inserir($dados)
  {
    return $results = PermissoesModuloDao::confereInserir([
      'modulo' => $dados,
      'usuario' => $this->getUsuario(),
    ]);
  }

  public function alterar($dados)
  {
    return $results = PermissoesModuloDao::confereAlterar([
      'modulo' => $dados,
      'usuario' => $this->getUsuario(),
    ]);
  }

  public function excluir($dados)
  {
    return $results = PermissoesModuloDao::confereExcluir([
      'modulo' => $dados,
      'usuario' => $this->getUsuario(),
    ]);
  }
}
