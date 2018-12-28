<?php

namespace App\Http\Controllers;

use App\Http\Dao\MaloteDocumentoDao;
use App\Http\Dao\DocumentoDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\SetorDao;
use App\Http\Dao\RotaEnderecoDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class MaloteDocumentoController extends Controller
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
    $results = MaloteDocumentoDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista($id)
  {
    $results = MaloteDocumentoDao::lista($id);

    return response()->json([
      'registros' => $results,
    ], 200);
  }

  public function seleciona($id)
  {
    $results = MaloteDocumentoDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'tipoDocumento' => 'required',
        'numero' => 'required',
        'setor' => 'required',
        'rotaEndereco' => 'required',
        'malote' => 'required'
      ]
    );

    $maloteDocumento = $this->request->all();
    $maloteDocumento['usuarioCriador'] = $this->getUsuario();
    $results = MaloteDocumentoDao::salva($maloteDocumento);
    $maloteDocumento['maloteDocumento'] = MaloteDocumentoDao::last()->id;

    $maloteDocumento['lista'] = MaloteDocumentoDao::lista($maloteDocumento['malote']);
    return response()->json(['maloteDocumento' =>$maloteDocumento], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'rota' => 'required',
        'endereco' => 'required'
      ]
    );

    $maloteDocumento = $this->request->all();
    $maloteDocumento['usuarioAlterador'] = $this->getUsuario();
    $results = MaloteDocumentoDao::altera($maloteDocumento);
    return response()->json(['maloteDocumento' =>$maloteDocumento], 202);
  }

  public function options($rota)
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $setor = SetorDao::options();
    $rotaEndereco = RotaEnderecoDao::options($rota);
    return response()->json([
      'tipoDocumento' => $tipoDocumento,
      'setor' => $setor,
      'rotaEndereco' => $rotaEndereco
    ], 200);
  }
}
