<?php

namespace App\Http\Controllers;

use App\Http\Dao\MaloteDao;
use App\Http\Dao\MaloteDocumentoDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use App\Http\Dao\RotaDao;
use App\Http\Dao\RotaEnderecoDao;

use Illuminate\Http\Request;
use App\ChromePhp;
use \PDF;

class BuscaMaloteController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function lista()
  {

    $this->validate($this->request,['busca' => 'required']);

    $dados = $this->request->all();
    $results = MaloteDao::procura($dados);

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
      'protocolo' => $id,
      'ano' => $ano
    ];
    $malote = MaloteDao::selecionaPorAno($dados);
    $documentos = MaloteDocumentoDao::lista($malote[0]->malote);
    return response()->json([
      'malote' => $malote[0],
      'maloteDocumentos' => $documentos,
    ], 200);
  }

  public function procuraDocumento()
  {

    $dados = $this->request->all();

    $dados['consultaData'] = '';
    $results = MaloteDocumentoDao::procuraDocumento($dados);

    return response()->json($results, 200);
  }

  public function relatorio()
  {
    $dados = $this->request->all();
    $malote = MaloteDao::selecionaPorAno($dados);
    $documentos = MaloteDocumentoDao::lista($malote[0]->malote);
    if ($dados['protocolo']) {
      // gera relatorio de um doc
      $obj = [
        'protocolo' => $dados['protocolo'],
        'ano' => $dados['ano']
      ];
      $malote = MaloteDao::selecionaPorAno($dados);
      $documentos = MaloteDocumentoDao::lista($malote[0]->malote);
    } else {
      // // pesquisa o doc e tras os dados
      // $dados['consultaData'] = '';

      // if ($dados['tipoData'] === 'data') {
      //   $dados['consultaData'] = "correspondencias.dataCadastro LIKE '%".$dados['dataCadastro']."%' AND ";
      //   $inicio = explode("-", $dados['dataCadastro']);
      //   $periodo = $inicio[2].'/'.$inicio[1].'/'.$inicio[0];

      // } elseif ($dados['tipoData'] === 'periodo' and ($dados['dataInicial'] !== '' and $dados['dataFinal'] !== '')) {
      //   $inicio = explode("-", $dados['dataInicial']);
      //   $inicio = $inicio[2].'/'.$inicio[1].'/'.$inicio[0];

      //   $fim = explode("-", $dados['dataFinal']);
      //   $fim = $fim[2].'/'.$fim[1].'/'.$fim[0];

      //   $periodo = $inicio.' - '.$fim;
      //   $dados['consultaData'] = "(DATE(correspondencias.dataCadastro) BETWEEN '".$dados['dataInicial']."'  AND '".$dados['dataFinal']."') AND ";
      // } elseif ($dados['tipoData'] === 'mes' and $dados['mesCadastro'] !== '') {

      //   $temp = explode("-", $dados['mesCadastro']);
      //   $periodo = $temp[1].'/'.$temp[0];

      //   $data = explode("-", $dados['mesCadastro']);
      //   $dados['consultaData'] = "(YEAR(correspondencias.dataCadastro) = '".$data[0]."' AND MONTH(correspondencias.dataCadastro) = '".$data[1]."' ) AND ";
      // }
      // $results = MaloteDao::procuraMalote($dados);
    }

    $relatorioView;
    $relatorioTitulo;
    $url = env('URL', '');

    // gera o pdf com os results
    // if ($dados['tipoConsulta'] === 'listagemDeMalote') {
      $relatorioView = 'Malote';
      $relatorioTitulo = 'relatorio-malote';
    // } else if ($dados['tipoConsulta'] === 'controleDeRegistroDePostagem') {
      // $relatorioView = 'ControleRegistroPostagem';
      // $relatorioTitulo = 'relatorio-registro-postagem';
    // }

    ChromePhp::log($dados);
    ChromePhp::log([
      'malote' => $malote,
      'documentos' => $documentos
    ]);


    $pdf = PDF::loadHTML(view($relatorioView, [
      'malote' => $malote[0],
      'documentos' => $documentos
      ]));
    $pdf->save('../public/pdf/'.$relatorioTitulo.'.pdf');

    return response()->json(['link' => $url."/pdf/".$relatorioTitulo.'.pdf'], 200);
    // return view('ListagemMalote', ['dados' => $results]);
  }

  public function options()
  {
    $tipoDocumento = TipoDocumentoDao::options();
    $endereco = EnderecoDao::options();
    $setor = SetorDao::options();
    $anos = MaloteDao::listaAnos();
    $rota = RotaDao::options();
    $rotaEndereco = RotaEnderecoDao::listaRotasEnderecos();
    return response()->json([
      'anos' => $anos,
      'tipoDocumento' => $tipoDocumento,
      'endereco' => $endereco,
      'setor' => $setor,
      'rota' => $rota,
      'rotaEndereco' => $rotaEndereco
    ], 200);
  }

}
