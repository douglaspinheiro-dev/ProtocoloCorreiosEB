<?php

namespace App\Http\Controllers;

use App\Http\Dao\ProtocoloEntradaDao;
use App\Http\Dao\TipoDocumentoDao;
use App\Http\Dao\EnderecoDao;
use App\Http\Dao\SetorDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class BotController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sugereDestino()
    {

        $this->validate($this->request,[
            'assunto' => 'required'
        ]);

        $dados = $this->request->all();
        $results = ProtocoloEntradaDao::sugereDestino($dados['assunto']);
        return response()->json($results, 200);
    }

}
