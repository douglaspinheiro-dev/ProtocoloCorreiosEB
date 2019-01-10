<?php

namespace App\Http\Controllers;

use App\Http\Dao\ProtocoloEntradaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class ProtocoloEntradaController extends Controller
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
    $results = ProtocoloEntradaDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = ProtocoloEntradaDao::lista($dados);

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
    $results = ProtocoloEntradaDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'tipoDocumento' => 'required',
        'numero' => 'required',
        'dataDocumento' => 'required',
        'origem' => 'required',
        'assunto' => 'required',
        'setor' => 'required',
        'enderecoCadastrado' => 'required'
      ]
    );

    $protocoloEntrada = $this->request->all();
    $protocoloEntrada['anoCadastro'] = date( 'Y', strtotime($protocoloEntrada['dataDocumento']) );
    $protocoloEntrada['usuarioCriador'] = $this->getUsuario();
    $protocoloEntrada['protocoloEntrada'] = md5(uniqid(rand(), true));
    $results = ProtocoloEntradaDao::salva($protocoloEntrada);
    return response()->json(['protocoloEntrada' =>$protocoloEntrada], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'protocoloEntrada' => 'required',
        'tipoDocumento' => 'required',
        'numero' => 'required',
        'dataDocumento' => 'required',
        'origem' => 'required',
        'assunto' => 'required',
        'setor' => 'required',
        'enderecoCadastrado' => 'required'

      ]
    );

    $protocoloEntrada = $this->request->all();
    $protocoloEntrada['usuarioAlterador'] = $this->getUsuario();
    $results = ProtocoloEntradaDao::altera($protocoloEntrada);
    return response()->json(['protocoloEntrada' =>$protocoloEntrada], 202);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    return response()->json([
      'tipoDocumento' => $tipoDocumento,
      'endereco' => $endereco,
      'setor' => $setor,
    ], 200);
  }

  public function listaAnos()
  {
    $anos = ProtocoloEntradaDao::listaAnos();
    return response()->json($anos, 200);
  }
}
