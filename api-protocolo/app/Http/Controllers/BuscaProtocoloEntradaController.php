<?php

namespace App\Http\Controllers;

use App\Http\Dao\ProtocoloEntradaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class BuscaProtocoloEntradaController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function lista()
  {

    $this->validate($this->request,['busca' => 'required']);

    $dados = $this->request->all();
    $results = ProtocoloEntradaDao::procura($dados);

    $fimDaLista = false;
    if (count($results) < $dados['fim']) {
      $fimDaLista = true;
    }
    return response()->json([
      'fim'       => $fimDaLista,
      'registros' => $results,
    ], 200);
  }

  public function seleciona($id, $ano)
  {
    // $this->validate($this->request,[
    //   'protocolo' => 'required',
    //   'ano' => 'required'
    // ]);

    $dados = [
      'id' => $id,
      'ano' => $ano
    ];
    $results = ProtocoloEntradaDao::selecionaPorAno($dados);
    return response()->json($results, 200);
  }



  public function options()
  {
    $anos = ProtocoloEntradaDao::listaAnos();
    return response()->json([
      'anos' => $anos,
    ], 200);
  }

}
