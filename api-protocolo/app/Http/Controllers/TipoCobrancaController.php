<?php

namespace App\Http\Controllers;

use App\Http\Dao\TipoCobrancaDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class TipoCobrancaController extends Controller
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
    $results = TipoCobrancaDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = TipoCobrancaDao::lista($dados);

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
    $results = TipoCobrancaDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $tipoCobranca = $this->request->all();
    $tipoCobranca['usuarioCriador'] = $this->getUsuario();
    $results = TipoCobrancaDao::salva($tipoCobranca);
    $tipoCobranca['tipoCobranca'] = TipoCobrancaDao::last()->id;
    return response()->json(['tipoCobranca' =>$tipoCobranca], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'tipoCobranca' => 'required',
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $tipoCobranca = $this->request->all();
    $tipoCobranca['usuarioAlterador'] = $this->getUsuario();
    $results = TipoCobrancaDao::altera($tipoCobranca);
    return response()->json(['tipoCobranca' =>$tipoCobranca], 202);
  }

  public function options()
  {
    $tipoCobranca = GrupoTipoCobrancaDao::lista();
    return response()->json([
      'tipoCobrancas' => $tipoCobranca,
    ], 200);
  }
}
