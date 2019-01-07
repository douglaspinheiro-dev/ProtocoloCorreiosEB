<?php

namespace App\Http\Controllers;

use App\Http\Dao\CorrespondenciaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\TipoCorrespondenciaDao;
use App\Http\Dao\TipoCobrancaDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class CorrespondenciaController extends Controller
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
    $results = CorrespondenciaDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = CorrespondenciaDao::lista($dados);

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
    $results = CorrespondenciaDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'tipoDocumento' => 'required',
        'numeroDocumento' => 'required',
        'setor' => 'required',
        'destino' => 'required',
        'enderecoCadastrado' => 'required',
        'cep' => 'required'
      ]
    );

    $correspondencia = $this->request->all();
    $correspondencia['anoCadastro'] = date( 'Y', strtotime($correspondencia['dataCadastro']) );
    $correspondencia['usuarioCriador'] = $this->getUsuario();
    $correspondencia['correspondencia'] = md5(uniqid(rand(), true));
    $results = CorrespondenciaDao::salva($correspondencia);
    return response()->json(['correspondencia' =>$correspondencia], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'correspondencia' => 'required',
        'tipoDocumento' => 'required',
        'numeroDocumento' => 'required',
        'setor' => 'required',
        'destino' => 'required',
        'enderecoCadastrado' => 'required',
        'cep' => 'required'


      ]
    );

    $correspondencia = $this->request->all();
    $correspondencia['usuarioAlterador'] = $this->getUsuario();
    $results = CorrespondenciaDao::altera($correspondencia);
    return response()->json(['correspondencia' =>$correspondencia], 202);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    $tipoCorrespondencia = TipoCorrespondenciaDao::options();
    $tipoCobranca = TipoCobrancaDao::options();
    return response()->json([
      'tipoDocumento' => $tipoDocumento,
      'tipoCorrespondencia' => $tipoCorrespondencia,
      'tipoCobranca' => $tipoCobranca,
      'endereco' => $endereco,
      'setor' => $setor,
    ], 200);
  }
}
