<?php

namespace App\Http\Controllers;

use App\Http\Dao\TipoDocumentoDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class TipoDocumentoController extends Controller
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
    $results = TipoDocumentoDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = TipoDocumentoDao::lista($dados);

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
    $results = TipoDocumentoDao::seleciona($id);
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

    $tipoDocumento = $this->request->all();
    $tipoDocumento['usuarioCriador'] = $this->getUsuario();
    $results = TipoDocumentoDao::salva($tipoDocumento);
    $tipoDocumento['tipoDocumento'] = TipoDocumentoDao::last()->id;
    return response()->json(['tipoDocumento' =>$tipoDocumento], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'tipoDocumento' => 'required',
        'codigo' => 'required',
        'descricao' => 'required',
        'status' => 'required'
      ]
    );

    $tipoDocumento = $this->request->all();
    $tipoDocumento['usuarioAlterador'] = $this->getUsuario();
    $results = TipoDocumentoDao::altera($tipoDocumento);
    return response()->json(['tipoDocumento' =>$tipoDocumento], 202);
  }

  public function options()
  {
    $tipoDocumento = GrupoTipoDocumentoDao::lista();
    return response()->json([
      'tipoDocumentos' => $tipoDocumento,
    ], 200);
  }
}
