<?php

namespace App\Http\Controllers;

use App\Http\Dao\RotaEnderecoDao;
use App\Http\Dao\EnderecoDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class RotaEnderecoController extends Controller
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
    $results = RotaEnderecoDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista($id)
  {
    $results = RotaEnderecoDao::lista($id);

    return response()->json([
      'registros' => $results,
    ], 200);
  }

  public function seleciona($id)
  {
    $results = RotaEnderecoDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'endereco' => 'required',
        'rota' => 'required',
      ]
    );

    $rota = $this->request->all();
    $rota['usuarioCriador'] = $this->getUsuario();
    $results = RotaEnderecoDao::salva($rota);
    $rota['rotaEndereco'] = RotaEnderecoDao::last()->id;

    $rota['lista'] = RotaEnderecoDao::lista($rota['rota']);
    return response()->json(['rota' =>$rota], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'rota' => 'required',
        'endereco' => 'required'
      ]
    );

    $rota = $this->request->all();
    $rota['usuarioAlterador'] = $this->getUsuario();
    $results = RotaEnderecoDao::altera($rota);
    return response()->json(['rota' =>$rota], 202);
  }

  public function options()
  {
    $endereco = EnderecoDao::optionsRota();
    return response()->json([
      'endereco' => $endereco,
    ], 200);
  }
}
