<?php

namespace App\Http\Controllers;

use App\Http\Dao\CorrespondenciaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;
use \PDF;

class BuscaCorrespondenciaController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function lista()
  {

    $this->validate($this->request,['busca' => 'required']);

    $dados = $this->request->all();
    $results = CorrespondenciaDao::procura($dados);

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
    $results = CorrespondenciaDao::selecionaPorAno($dados);
    return response()->json($results, 200);
  }

  public function procuraCorrespondencia()
  {

    $dados = $this->request->all();

    if (($dados['dataInicial'] !== '' and $dados['dataFinal'] !== '') or $dados['mesCadastro'] !== ''  ) {
      if ($dados['tipoData'] === 'data') {
        // $dados['consultaData'] = "correspondencias.dataDocumento LIKE '%".$dados['dataDocumento']."%' AND ";
      } elseif ($dados['tipoData'] === 'periodo') {
        $dados['consultaData'] = "(DATE(correspondencias.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataInicial']."') AND ";
      } elseif ($dados['tipoData'] === 'mes') {
        $data = explode("-", $dados['mesCadastro']);
        $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) AND ";
      }
    } else {
      $dados['consultaData'] = '';
    }


    $results = CorrespondenciaDao::procuraCorrespondencia($dados);

    $valorTotal = 0;
    foreach ($results as $row) {
      $valorTotal += $row->valorTotal;
    }
    return response()->json([
      'correspondencias' => $results,
      'valorTotal' => $valorTotal
    ], 200);
  }

  public function relatorio()
  {
    $results;
    $dados = $this->request->all();
    if ($dados['protocolo']) {
      // gera relatorio de um doc
      $obj = [
        'id' => $dados['protocolo'],
        'ano' => $dados['ano']
      ];
      $results = CorrespondenciaDao::selecionaPorAno($dados);
    } else {
      // pesquisa o doc e tras os dados

      if (($dados['dataInicial'] !== '' and $dados['dataFinal'] !== '') or $dados['mesCadastro'] !== ''  ) {
        if ($dados['tipoData'] === 'data') {
          // $dados['consultaData'] = "correspondencias.dataDocumento LIKE '%".$dados['dataDocumento']."%' AND ";
        } elseif ($dados['tipoData'] === 'periodo') {
          $dados['consultaData'] = "(DATE(correspondencias.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataInicial']."') AND ";
        } elseif ($dados['tipoData'] === 'mes') {
          $data = explode("-", $dados['mesCadastro']);
          $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) AND ";
        }
      } else {
        $dados['consultaData'] = '';
      }
      $results = CorrespondenciaDao::procuraCorrespondencia($dados);
    }

    // gera o pdf com os results

    $pdf = PDF::loadHTML(view('ListagemCorrespondencia', ['dados' => $results]));
    $pdf->save('../public/pdf/relatorio-correspondencia.pdf');
    $url = env('URL', '');

    return response()->json(['link' => $url.'/pdf/relatorio-correspondencia.pdf'], 200);
    // return view('ListagemCorrespondencia', ['dados' => $results]);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    $anos = CorrespondenciaDao::listaAnos();
    return response()->json([
      'anos' => $anos,
      'tipoDocumento' => $tipoDocumento,
      'endereco' => $endereco,
      'setor' => $setor,
    ], 200);
  }

}
