<?php

namespace App\Http\Controllers;

use App\Http\Dao\TipoCorrespondenciaDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class TipoCorrespondenciaController extends Controller
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
    $results = TipoCorrespondenciaDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = TipoCorrespondenciaDao::lista($dados);

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
    $results = TipoCorrespondenciaDao::seleciona($id);
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

    $tipoCorrespondencia = $this->request->all();
    $tipoCorrespondencia['usuarioCriador'] = $this->getUsuario();
    $results = TipoCorrespondenciaDao::salva($tipoCorrespondencia);
    $tipoCorrespondencia['tipoCorrespondencia'] = TipoCorrespondenciaDao::last()->id;
    return response()->json(['tipoCorrespondencia' =>$tipoCorrespondencia], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'tipoCorrespondencia' => 'required',
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $tipoCorrespondencia = $this->request->all();
    $tipoCorrespondencia['usuarioAlterador'] = $this->getUsuario();
    $results = TipoCorrespondenciaDao::altera($tipoCorrespondencia);
    return response()->json(['tipoCorrespondencia' =>$tipoCorrespondencia], 202);
  }

  public function options()
  {
    $tipoCorrespondencia = GrupoTipoCorrespondenciaDao::lista();
    return response()->json([
      'tipoCorrespondencias' => $tipoCorrespondencia,
    ], 200);
  }
}
