<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Dao\PermissoesModuloDao;
use Illuminate\Http\Request;
use App\ChromePhp;

class Controller extends BaseController
{


  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function getUsuario()
  {
    return $this->request->auth['0']->usuario;
  }


  // public function validaAbrir($dados)
  // {
  //   return $results = PermissoesModuloDao::confereAbrir([
  //     'modulo' => $dados,
  //     'usuario' => $this->getUsuario(),
  //   ])[0]->abrir;
  // }

  // public function validaInserir($dados)
  // {
  //   return $results = PermissoesModuloDao::confereInserir([
  //     'modulo' => $dados,
  //     'usuario' => $this->usuario,
  //   ]);
  // }

  // public function validaAlterar($dados)
  // {
  //   return $results = PermissoesModuloDao::confereAlterar([
  //     'modulo' => $dados,
  //     'usuario' => $this->usuario,
  //   ]);
  // }

  // public function validaExcluir($dados)
  // {
  //   return $results = PermissoesModuloDao::confereExcluir([
  //     'modulo' => $dados,
  //     'usuario' => $this->usuario,
  //   ]);
  // }
}
