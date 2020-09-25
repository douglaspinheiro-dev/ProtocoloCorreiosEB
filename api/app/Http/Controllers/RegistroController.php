<?php

namespace App\Http\Controllers;

use App\Http\Dao\RegistroDao;
use Illuminate\Http\Request;
use App\ChromePhp;

class RegistroController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function confere()
  {
    $this->validate($this->request,
      [
        'tabela' => 'required',
        'campo' => 'required',
        'campoId' => 'required',
        'valor' => 'required',
        'opcao' => 'required',
      ]
    );
    $dados = $this->request->all();
    $results = RegistroDao::confere($dados);

    if (count($results) === 0) {
      return response()->json(['resposta' => true], 200);
    } else {
      $resposta;
      $resultado = (array) $results[0];
      $campo = $dados['campo'];

      if ($resultado) {

        if ($resultado[$campo] == '') {
          // busca retornou vazia, entao o registro pode ser cadastrado
          $resposta = true;
        } else if ($resultado[$campo] != '' && $dados['opcao'] == 'alterar' && $resultado[$dados['campoId']] == $dados['id']) {
          $resposta = true;
        } else if ($resultado[$campo] != '' && $dados['opcao'] == 'alterar' && $resultado[$dados['campoId']] != $dados['id']) {
          $resposta = false;
        } else if ($resultado[$campo] != '' && $dados['opcao'] == 'gravar') {
          $resposta = false;
        }
      } else {
        // resultado vazio, logo nao tem registros na tabela
        $resposta = true;
      }
    }
    return response()->json(['resposta' => $resposta], 200);
  }

}
