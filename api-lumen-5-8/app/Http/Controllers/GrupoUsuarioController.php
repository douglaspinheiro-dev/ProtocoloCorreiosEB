<?php

namespace App\Http\Controllers;

use App\Http\Dao\GrupoUsuarioDao;
use App\Http\Dao\PermissoesModuloDao;
use App\Http\Dao\LoginDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class GrupoUsuarioController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function apaga($id)
  {
    $auth = $this->request->usuario;
    $dados = [
      'grupoUsuario' => $id,
      'usuarioAlterador' => $this->getUsuario()
    ];
    $results = GrupoUsuarioDao::apaga($dados);
    return response()->json('', 204);
  }

  public function lista()
  {
    $this->validate($this->request,['inicio' => 'required', 'fim' => 'required']);

    $dados = $this->request->all();
    $results = GrupoUsuarioDao::lista($dados);

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
    function convertePermissoes ($permissoes) {
      $novasPermissoes = [];

      foreach ($permissoes as $permissao) {
        $novasPermissoes[$permissao->nomeHtml] = [];
        if ($permissao->abrir === 1) { array_push($novasPermissoes[$permissao->nomeHtml], "abrir");}
        if ($permissao->inserir === 1) { array_push($novasPermissoes[$permissao->nomeHtml], "inserir");}
        if ($permissao->alterar === 1) { array_push($novasPermissoes[$permissao->nomeHtml], "alterar");}
        if ($permissao->excluir === 1) { array_push($novasPermissoes[$permissao->nomeHtml], "excluir");}
      };
      return $novasPermissoes;
    }

    $results = GrupoUsuarioDao::buscaPorId($id);
    ChromePhp::log($results);

    $resposta = [
      'grupoUsuario' => $results[0]->categoriaUsuario,
      'codigo' => $results[0]->codigo,
      'descricao' => $results[0]->descricao,
      'usuarioCriador' => $results[0]->usuarioCriador,
      'permissoes' => convertePermissoes($results)
    ];
    return response()->json($resposta, 200);
  }

  public function salva()
  {
    $this->validate($this->request,
      [
        'codigo' => 'required',
        'descricao' => 'required'
      ]
    );

    $grupoUsuario = $this->request->all();
    $grupoUsuario['usuarioCriador'] = $this->getUsuario();
    $results = GrupoUsuarioDao::salva($grupoUsuario);
    $grupoUsuario['grupoUsuario'] = GrupoUsuarioDao::last()->id;


    $novasPermissoes = $this->preparaPermissoes($grupoUsuario['permissoes'], $grupoUsuario['grupoUsuario']);
    $results = PermissoesModuloDao::salva($novasPermissoes);

    return response()->json([
      'grupoUsuario' => $grupoUsuario
    ], 201);
  }

  public function altera()
  {
    $this->validate($this->request,
      [
        'codigo' => 'required',
        'descricao' => 'required',
        'usuarioCriador' => 'required'
      ]
    );

    $grupoUsuario = $this->request->all();
    ChromePhp::log($grupoUsuario);

    $grupoUsuario['usuarioAlterador'] = $this->getUsuario();
    $results = GrupoUsuarioDao::altera($grupoUsuario);
    $results = PermissoesModuloDao::apaga($grupoUsuario['grupoUsuario']);



    $novasPermissoes = $this->preparaPermissoes($grupoUsuario['permissoes'], $grupoUsuario['grupoUsuario']);
    ChromePhp::log($novasPermissoes);
    $results = PermissoesModuloDao::salva($novasPermissoes);
    $results = PermissoesModuloDao::lista($grupoUsuario['grupoUsuario']);

    $permissoes = $results;
    $novasPermissoes = [];
    foreach ($permissoes as $permissao) {
      $novasPermissoes[$permissao->nomeHtml] = $permissao;
    };

    return response()->json([
      'grupoUsuario' => $grupoUsuario,
      'permissoes' => $novasPermissoes
    ], 202);
  }

  public function options()
  {
    $categoriaUsuario = CategoriaGrupoUsuarioDao::lista();
    return response()->json([
      'grupoUsuarios' => $categoriaUsuario,
    ], 200);
  }

  public function preparaPermissoes($permissoes, $grupoUsuario) {
    $novasPermissoes = [];
    ChromePhp::log('perissao Original',$permissoes);

    foreach ($permissoes as $key => $value) {


      $permissaoPadrao = [];
      $permissaoPadrao['abrir'] = 0;
      $permissaoPadrao['inserir'] = 0;
      $permissaoPadrao['alterar'] = 0;
      $permissaoPadrao['excluir'] = 0;
      $permissaoPadrao['nomeHtml'] = $key;
      $permissaoPadrao['categoriaUsuario'] = $grupoUsuario;

      if(count($value) > 0){

        if ($permissoes[$key]) {
          foreach ($permissoes[$key] as $chave) {
            $permissaoPadrao[$chave] = 1;
          }
        }
      }
      array_push($novasPermissoes, $permissaoPadrao);

    }
    ChromePhp::log('novas permissoes ',$novasPermissoes);

    return $novasPermissoes;
  }
}
