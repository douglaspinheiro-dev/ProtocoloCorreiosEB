<?php

namespace App\Http\Controllers;

use App\Http\Dao\MaloteDao;
use App\Http\Dao\RotaDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class MaloteController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function apaga($id)
  {
    $dados = [
      'id' => $id,
      'usuarioAlterador' => $this->getUsuario()
    ];
    $results = MaloteDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = MaloteDao::lista($dados);

    $fimDaLista = false;
    if (count($results) < $dados['fim']) {
      $fimDaLista = true;
    }
    return response()->json([
      'fim'       => $fimDaLista,
      'registros' => $results,
    ], 200);
  }

  public function seleciona($id)
  {
    $results = MaloteDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'data' => 'required',
        'rota' => 'required',
      ]
    );

    $malote = $this->request->all();
    $malote['anoCadastro'] = date( 'Y', strtotime($malote['data']) );
    $malote['malote'] = md5(uniqid(rand(), true));
    $malote['usuarioCriador'] = $this->getUsuario();
    $results = MaloteDao::salva($malote);
    return response()->json(['malote' =>$malote], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'rota' => 'required',
        'data' => 'required',
        'malote' => 'required'
      ]
    );

    $malote = $this->request->all();
    $malote['usuarioAlterador'] = $this->getUsuario();
    $results = MaloteDao::altera($malote);
    return response()->json(['malote' =>$malote], 202);
  }

  public function options()
  {
    $rota = RotaDao::options();
    return response()->json([
      'rotas' => $rota,
    ], 200);
  }
}
