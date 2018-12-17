<?php

namespace App\Http\Controllers;

use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class SetorController extends Controller
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
    $results = SetorDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {

    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = SetorDao::lista($dados);

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
    $results = SetorDao::seleciona($id);
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

    $setor = $this->request->all();
    $setor['usuarioCriador'] = $this->getUsuario();
    $setor['codigoReduzido'] = $setor['codigo'];
    $setor['codigoReduzido'] = str_replace(" ", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("ª", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("º", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("°", '', $setor['codigoReduzido']);
    $results = SetorDao::salva($setor);
    $setor['setor'] = SetorDao::last()->id;
    return response()->json(['setor' =>$setor], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'setor' => 'required',
        'descricao' => 'required',
        'codigo' => 'required',
        'status' => 'required'
      ]
    );

    $setor = $this->request->all();
    $setor['usuarioAlterador'] = $this->getUsuario();
    $setor['codigoReduzido'] = $setor['codigo'];
    $setor['codigoReduzido'] = str_replace(" ", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("ª", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("º", '', $setor['codigoReduzido']);
    $setor['codigoReduzido'] = str_replace("°", '', $setor['codigoReduzido']);
    $results = SetorDao::altera($setor);
    return response()->json(['setor' =>$setor], 202);
  }

  public function options()
  {
    $setor = GrupoSetorDao::lista();
    return response()->json([
      'setors' => $setor,
    ], 200);
  }
}
