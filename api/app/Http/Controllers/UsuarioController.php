<?php

namespace App\Http\Controllers;

use App\Http\Dao\UsuarioDao;
use App\Http\Dao\LoginDao;
use App\Http\Dao\GrupoUsuarioDao;
use Illuminate\Http\Request;
use App\ChromePhp;


class UsuarioController extends Controller
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
        $results = UsuarioDao::apaga($dados);
        return response()->json('', 204);
    }

    public function lista()
    {

        $this->validate($this->request, ['inicio' => 'required', 'fim' => 'required']);

        $dados = $this->request->all();
        $results = UsuarioDao::lista($dados);

        $fimDaLista = false;
        if (count($results) < $dados['fim']) {
            $fimDaLista = true;
        }
        return response()->json([
            'fim' => $fimDaLista,
            'registros' => $results,
        ], 200);
    }

    public function confereLogin()
    {
        $this->validate($this->request, ['login' => 'required']);
        $login = $this->request->input('login');
        $results = UsuarioDao::confereLogin($login);
        return response()->json($results, 200);
    }

    public function seleciona($id)
    {
        $results = UsuarioDao::seleciona($id);
        return response()->json($results[0], 200);
    }

    public function salva()
    {
        $this->validate(
            $this->request,
            [
                'nome' => 'required',
                'login' => 'required',
                'grupoUsuario' => 'required'
                ]
            );

            $usuario = $this->request->all();
            $usuario['usuarioCriador'] = $this->getUsuario();
            $results = UsuarioDao::salva($usuario);
            $usuario['usuario'] = UsuarioDao::last()->id;
            return response()->json(['usuario' => $usuario], 201);
        }

        public function altera()
        {
            $this->validate(
                $this->request,
                [
                    'usuario' => 'required',
                    'nome' => 'required',
                    'login' => 'required',
                    'grupoUsuario' => 'required'
                    ]
                );

                $usuario = $this->request->all();
                $usuario['usuarioAlterador'] = $this->getUsuario();
                $results = UsuarioDao::altera($usuario);
                return response()->json(['usuario' => $usuario], 202);
            }

            public function alteraSenha()
            {
                $this->validate(
                    $this->request,
                    [
                        'senhaAtual' => 'required',
                        'senhaNova' => 'required'
                        ]
                    );
                    $senhas = $this->request->all();
                    $login = $this->request->auth['0']->login;
                    $dados = [
                        'login' => $login,
                        'password' => $senhas['senhaAtual'],
                        'usuarioAlterador' => $this->getUsuario(),
                        'id' => $this->getUsuario()
                    ];
                    $loginValido = LoginDao::valida($dados);
                    if ($loginValido) {
                        // altera a senha
                        $dados['password'] = $senhas['senhaNova'];
                        $results = UsuarioDao::alteraSenha($dados);
                        $response = [
                            'status' => 'sucess'
                        ];
                        return response()->json($response, 202);
                    } else {
                        return response()->json(["message" => 'dados inválidos'], 401);
                    }

                    $results = UsuarioDao::salva($usuario);
                    return response()->json($results, 201);
                }

                public function alteraSenhaOutroUsuario()
                {
                    $this->validate(
                        $this->request,
                        [
                            'id' => 'required',
                            'password' => 'required',
                            'usuarioCriador' => 'required'
                            ]
                        );
                        $dados = $this->request->all();
                        $dados['usuarioAlterador'] = $this->getUsuario();
                        $results = UsuarioDao::alteraSenha($dados);
                        return response()->json('', 201);
                    }

                    public function options()
                    {
                        $categoriaUsuario = GrupoUsuarioDao::lista();
                        return response()->json([
                            'grupoUsuarios' => $categoriaUsuario,
                        ], 200);
                    }
                }
