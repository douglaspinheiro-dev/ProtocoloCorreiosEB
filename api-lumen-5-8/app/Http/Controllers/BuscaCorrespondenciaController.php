<?php

namespace App\Http\Controllers;

use App\Http\Dao\CorrespondenciaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\TipoCorrespondenciaDao;
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
    if ($dados['tipoRelatorio'] === 'listagemDeCorrespondencia') {
      $results = CorrespondenciaDao::selecionaPorAno($dados);
    } else {
      $results = CorrespondenciaDao::selecionaPorAnoComRastreio($dados);
    }
    return response()->json($results, 200);
  }

  public function procuraCorrespondencia()
  {

    $dados = $this->request->all();

    $dados['consultaData'] = '';
    if ($dados['tipoData'] === 'data')  {
      $dados['consultaData'] = "correspondencias.dataCadastro LIKE '%".$dados['dataCadastro']."%' ";
    } elseif ($dados['tipoData'] === 'periodo' and ($dados['dataInicial'] !== '' and $dados['dataFinal'] !== '')) {
      $dados['consultaData'] = "(DATE(correspondencias.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataFinal']."') ";
    } elseif ($dados['tipoData'] === 'mes' and $dados['mesCadastro'] !== '' ) {
      $data = explode("-", $dados['mesCadastro']);
      $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) ";
    }

    if ($dados['tipoRelatorio'] === 'listagemDeCorrespondencia') {
      $results = CorrespondenciaDao::procuraCorrespondencia($dados);
    } else {
      $results = CorrespondenciaDao::procuraCorrespondenciaComRastreio($dados);
    }

    $valorTotal = 0;
    foreach ($results as $row) {
      $valorTotal += $row->valorTotal;
    }
    return response()->json([
      'correspondencias' => $results,
      'valorTotal' => $valorTotal
    ], 200);
  }

  public function procuraCorrespondenciaPublico()
  {

    $dados = $this->request->all();

    $dados['consultaData'] = '';
    $data = explode("-", $dados['mesCadastro']);
    $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) ";

    $results = CorrespondenciaDao::procuraCorrespondenciaComRastreioPublico($dados);

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
    $periodo = '';
    $dados = $this->request->all();
    if ($dados['protocolo']) {
      // gera relatorio de um doc
      $obj = [
        'id' => $dados['protocolo'],
        'ano' => $dados['ano']
      ];
      if ($dados['tipoRelatorio'] === 'listagemDeCorrespondencia') {
        $results = CorrespondenciaDao::selecionaPorAno($dados);
      } else {
        $results = CorrespondenciaDao::selecionaPorAnoComRastreio($dados);
      }
    } else {
      // pesquisa o doc e tras os dados
      $dados['consultaData'] = '';

      if ($dados['tipoData'] === 'data') {
        $dados['consultaData'] = "correspondencias.dataCadastro LIKE '%".$dados['dataCadastro']."%' ";
        $inicio = explode("-", $dados['dataCadastro']);
        $periodo = $inicio[2].'/'.$inicio[1].'/'.$inicio[0];

      } elseif ($dados['tipoData'] === 'periodo' and ($dados['dataInicial'] !== '' and $dados['dataFinal'] !== '')) {
        $inicio = explode("-", $dados['dataInicial']);
        $inicio = $inicio[2].'/'.$inicio[1].'/'.$inicio[0];

        $fim = explode("-", $dados['dataFinal']);
        $fim = $fim[2].'/'.$fim[1].'/'.$fim[0];

        $periodo = $inicio.' - '.$fim;
        $dados['consultaData'] = "(DATE(correspondencias.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataFinal']."') ";
      } elseif ($dados['tipoData'] === 'mes' and $dados['mesCadastro'] !== '') {

        $temp = explode("-", $dados['mesCadastro']);
        $periodo = $temp[1].'/'.$temp[0];

        $data = explode("-", $dados['mesCadastro']);
        $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) ";
      }
      if ($dados['tipoRelatorio'] === 'listagemDeCorrespondencia') {
        $results = CorrespondenciaDao::procuraCorrespondencia($dados);
      } else {
        $results = CorrespondenciaDao::procuraCorrespondenciaComRastreio($dados);
      }
    }

    $relatorioView;
    $relatorioTitulo;
    $url = env('URL', '');

    // gera o pdf com os results
    if ($dados['tipoRelatorio'] === 'listagemDeCorrespondencia') {
      $relatorioView = 'ListagemCorrespondencia';
      $relatorioTitulo = 'relatorio-correspondencia';
    } else if ($dados['tipoRelatorio'] === 'controleDeRegistroDePostagem') {
      $relatorioView = 'ControleRegistroPostagem';
      $relatorioTitulo = 'relatorio-registro-postagem';
    }

    $caminhoPdfInterno = '../public/pdf/'.$relatorioTitulo.'.pdf';
    $caminhoPdfExterno = $url."/pdf/".$relatorioTitulo.'.pdf';
    if(file_exists($caminhoPdfInterno)){ unlink($caminhoPdfInterno); }

    PDF::loadHTML(view($relatorioView, [
      'dados' => $results,
      'periodo' => $periodo
      ]))
      ->setPaper('a4')
      ->setOrientation('portrait')
      ->setOption('margin-bottom', 1)
      ->save($caminhoPdfInterno);

    return response()->json(['link' => $caminhoPdfExterno], 200);
  }

  public function relatorioPublico()
  {
    $results;
    $periodo = '';
    $dados = $this->request->all();

    // pesquisa o doc e tras os dados
    $dados['consultaData'] = '';

    $temp = explode("-", $dados['mesCadastro']);
    $periodo = $temp[1].'/'.$temp[0];
    $data = explode("-", $dados['mesCadastro']);
    $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) AND ";
    $results = CorrespondenciaDao::procuraCorrespondenciaComRastreioPublico($dados);

    $relatorioView;
    $relatorioTitulo;
    $url = env('URL', '');

    // gera o pdf com os results
    $relatorioView = 'ControleRegistroPostagem';
    $relatorioTitulo = 'relatorio-registro-postagem';


    $caminhoPdfInterno = '../public/pdf/'.$relatorioTitulo.'.pdf';
    $caminhoPdfExterno = $url."/pdf/".$relatorioTitulo.'.pdf';
    if(file_exists($caminhoPdfInterno)){ unlink($caminhoPdfInterno); }
    PDF::loadHTML(view($relatorioView, [
      'dados' => $results,
      'periodo' => $periodo
      ]))
      ->setPaper('a4')
      ->setOrientation('portrait')
      ->setOption('margin-bottom', 0)
      ->save($caminhoPdfInterno);

    return response()->json(['link' => $caminhoPdfExterno], 200);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $tipoCorrespondencia = TipoCorrespondenciaDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    $anos = CorrespondenciaDao::listaAnos();
    return response()->json([
      'anos' => $anos,
      'tipoDocumento' => $tipoDocumento,
      'tipoCorrespondencia' => $tipoCorrespondencia,
      'endereco' => $endereco,
      'setor' => $setor,
    ], 200);
  }

}
