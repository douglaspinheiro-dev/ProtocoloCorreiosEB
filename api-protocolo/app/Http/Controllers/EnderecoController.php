<?php

namespace App\Http\Controllers;

use App\Http\Dao\EnderecoDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class EnderecoController extends Controller
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
    $results = EnderecoDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = EnderecoDao::lista($dados);

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
    $results = EnderecoDao::seleciona($id);
    return response()->json($results[0], 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'descricao' => 'required',
        'codigo' => 'required',
        'status' => 'required'
      ]
    );

    $endereco = $this->request->all();
    $endereco['usuarioCriador'] = $this->getUsuario();
    $results = EnderecoDao::salva($endereco);
    $endereco['endereco'] = EnderecoDao::last()->id;
    return response()->json(['endereco' =>$endereco], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'endereco' => 'required',
        'descricao' => 'required',
        'codigo' => 'required',
        'status' => 'required'
      ]
    );

    $endereco = $this->request->all();
    $endereco['usuarioAlterador'] = $this->getUsuario();
    $results = EnderecoDao::altera($endereco);
    return response()->json(['endereco' =>$endereco], 202);
  }

  public function options()
  {
    $endereco = GrupoEnderecoDao::lista();
    return response()->json([
      'enderecos' => $endereco,
    ], 200);
  }
}
