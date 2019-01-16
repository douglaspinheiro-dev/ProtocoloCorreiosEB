<?php

namespace App\Http\Controllers;

use App\Http\Dao\ProtocoloEntradaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;
use \PDF;

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

  public function procuraDocumento()
  {

    $dados = $this->request->all();

    if ($dados['tipoData'] === 'data') {
      $dados['consultaData'] = "protocoloEntradas.dataDocumento LIKE '%".$dados['dataDocumento']."%' AND ";
    } elseif ($dados['tipoData'] === 'periodo') {
      $dados['consultaData'] = "(DATE(protocoloEntradas.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataInicial']."') AND ";
    } elseif ($dados['tipoData'] === 'mes') {
      $data = explode("-", $dados['mesCadastro']);
      $dados['consultaData'] = "(YEAR(protocoloEntradas.dataCadastro) = '".$data[0]."' AND MONTH(protocoloEntradas.dataCadastro) = '".$data[1]."' ) AND ";
    }


    $results = ProtocoloEntradaDao::procuraDocumento($dados);
    return response()->json($results, 200);
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
      $results = ProtocoloEntradaDao::selecionaPorAno($dados);
    } else {
      // pesquisa o doc e tras os dados

      if ($dados['tipoData'] === 'data') {
        $dados['consultaData'] = "protocoloEntradas.dataDocumento LIKE '%".$dados['dataDocumento']."%' AND ";
      } elseif ($dados['tipoData'] === 'periodo') {
        $dados['consultaData'] = "(DATE(protocoloEntradas.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataInicial']."') AND ";
      } elseif ($dados['tipoData'] === 'mes') {
        $data = explode("-", $dados['mesCadastro']);
        $dados['consultaData'] = "(YEAR(protocoloEntradas.dataCadastro) = '".$data[0]."' AND MONTH(protocoloEntradas.dataCadastro) = '".$data[1]."' ) AND ";
      }
      $results = ProtocoloEntradaDao::procuraDocumento($dados);
    }

    // gera o pdf com os results

    $pdf = PDF::loadHTML(view('ListagemProtocoloEntrada', ['dados' => $results]));
    $pdf->save('../public/pdf/relatorio-protocolo-entrada.pdf');
    $url = env('URL', '');

    return response()->json(['link' => $url.'/pdf/relatorio-protocolo-entrada.pdf'], 200);
    // return view('ListagemProtocoloEntrada', ['dados' => $results]);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    $anos = ProtocoloEntradaDao::listaAnos();
    return response()->json([
      'anos' => $anos,
      'tipoDocumento' => $tipoDocumento,
      'endereco' => $endereco,
      'setor' => $setor,
    ], 200);
  }

}
