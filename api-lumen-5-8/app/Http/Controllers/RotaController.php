<?php

namespace App\Http\Controllers;

use App\Http\Dao\RotaDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class RotaController extends Controller
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
    $results = RotaDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = RotaDao::lista($dados);

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
    $results = RotaDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'codigo' => 'required',
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $rota = $this->request->all();
    $rota['usuarioCriador'] = $this->getUsuario();
    $results = RotaDao::salva($rota);
    $rota['rota'] = RotaDao::last()->id;
    return response()->json(['rota' =>$rota], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'rota' => 'required',
        'codigo' => 'required',
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $rota = $this->request->all();
    $rota['usuarioAlterador'] = $this->getUsuario();
    $results = RotaDao::altera($rota);
    return response()->json(['rota' =>$rota], 202);
  }

  public function options()
  {
    $rota = GrupoRotaDao::lista();
    return response()->json([
      'rotas' => $rota,
    ], 200);
  }
}
