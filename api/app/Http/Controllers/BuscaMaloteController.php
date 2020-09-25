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
        // gera relatorio de um doc
        $obj = [
            'protocolo' => $dados['protocolo'],
            'ano' => $dados['ano']
        ];
        $malote = MaloteDao::selecionaPorAno($dados);
        $documentos = MaloteDocumentoDao::lista($malote[0]->malote);

        $relatorioView;
        $relatorioTitulo;
        $url = env('URL', '');

        // gera o pdf com os results
        // if ($dados['tipoConsulta'] === 'listagemDeMalote') {
        $relatorioView = 'Malote';
        $relatorioTitulo = 'relatorio-malote';
        $caminhoPdfInterno = '../public/pdf/'.$relatorioTitulo.'.pdf';
        $caminhoPdfExterno = $url."/pdf/".$relatorioTitulo.'.pdf';
        if(file_exists($caminhoPdfInterno)){ unlink($caminhoPdfInterno); }
        $snappy = new PDF(env('CAMINHO_PDF'));
        $snappy::loadHTML(view($relatorioView, [
            'malote' => $malote[0],
            'documentos' => $documentos
        ]))
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-bottom', 0)
            ->save($caminhoPdfInterno);

        return response()->json(['link' => $caminhoPdfExterno], 200);
    }

    public function relatorioConsolidadoPorMes()
    {
        $dados = $this->request->all();
        $relatorioView = 'MalotePorMes';
        $relatorioTitulo = 'malote-por-mes';

        $dados['consultaData'] = '';
        $documentos = MaloteDocumentoDao::procuraMes($dados);
        $url = env('URL', '');
        $caminhoPdfInterno = '../public/pdf/'.$relatorioTitulo.'.pdf';
        $caminhoPdfExterno = $url."/pdf/".$relatorioTitulo.'.pdf';
        if(file_exists($caminhoPdfInterno)){ unlink($caminhoPdfInterno); }
        $snappy = new PDF(env('CAMINHO_PDF'));
        $snappy::loadHTML(view($relatorioView, [
            'documentos' => $documentos,
            'data' => $dados['mes'].'/'.$dados['ano']
        ]))->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-bottom', 1)
            ->save($caminhoPdfInterno);

        return response()->json(['link' => $caminhoPdfExterno], 200);


    }


    public function procuraMes()
    {

        $dados = $this->request->all();

        $dados['consultaData'] = '';
        $results = MaloteDocumentoDao::procuraMes($dados);

        return response()->json($results, 200);
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
