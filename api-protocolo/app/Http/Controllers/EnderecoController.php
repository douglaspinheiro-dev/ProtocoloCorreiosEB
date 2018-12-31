<?php

namespace App\Http\Controllers;

use App\Http\Dao\EnderecoDao;
use App\Http\Dao\RotaDao;
use App\Http\Dao\RotaEnderecoDao;
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
    $endereco = $results[0];
    if($endereco->malote) {
      $results = RotaEnderecoDao::selecionaEndereco($endereco->endereco);
      ChromePhp::log($endereco);
      ChromePhp::log($results);
      $endereco->rota = $results[0]->rota;
    }
    return response()->json($endereco, 200);
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
    $endereco['codigoReduzido'] = $endereco['codigo'];
    $endereco['codigoReduzido'] = str_replace(" ", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("ª", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("º", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("°", '', $endereco['codigoReduzido']);
    $results = EnderecoDao::salva($endereco);
    $endereco['endereco'] = EnderecoDao::last()->id;

    if($endereco['malote']){
      // se for rota pra malote, salva a rota na tabela de rotasEnderecos
      $rota['usuarioCriador'] = $this->getUsuario();
      $rota['endereco'] = $endereco['endereco'];
      $rota['rota'] = $endereco['rota'];
      $results = RotaEnderecoDao::salva($rota);
    }
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
    $endereco['codigoReduzido'] = $endereco['codigo'];
    $endereco['codigoReduzido'] = str_replace(" ", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("ª", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("º", '', $endereco['codigoReduzido']);
    $endereco['codigoReduzido'] = str_replace("°", '', $endereco['codigoReduzido']);
    $results = EnderecoDao::altera($endereco);

    $results = RotaEnderecoDao::apagaEndereco($endereco['endereco']);
    if($endereco['malote']){
      // se for rota pra malote, salva a rota na tabela de rotasEnderecos
      $rota['usuarioCriador'] = $this->getUsuario();
      $rota['endereco'] = $endereco['endereco'];
      $rota['rota'] = $endereco['rota'];
      $results = RotaEnderecoDao::salva($rota);
    }

    return response()->json(['endereco' =>$endereco], 202);
  }

  public function options()
  {
    $rota = RotaDao::options();
    return response()->json([
      'rotas' => $rota,
    ], 200);
  }
}
