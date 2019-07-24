<?php
namespace App\Http\Controllers;
use Validator;
use App\Usuario;
// use App\Http\Controllers\PermissoesModuloController;
use Illuminate\Support\Facades\DB;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
class AuthController extends BaseController
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Create a new token.
     *
     * @param  \App\Usuario   $usuario
     * @return string
     */
    protected function jwt(Usuario $usuario) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $usuario->usuario, // Subject of the token
            'cat' => $usuario->categoriaUsuario, // Subject of the token
            'login' => $usuario->login, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60*10 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a usuario and return the token if the provided credentials are correct.
     *
     * @param  \App\Usuario   $usuario
     * @return mixed
     */
    public function authenticate(Usuario $usuario) {
        $this->validate($this->request, [
            'login'     => 'required',
            'password'  => 'required'
        ]);
        // Find the usuario by login
        $usuario = Usuario::where('login', $this->request->input('login'))->first();
        if (!$usuario) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
              'message' => 'Dados inválidos, logon negado.'
            ], 401);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $usuario->password)) {
          $permissoes = PermissoesModuloController::lista($usuario->categoriaUsuario);
          $novasPermissoes = [];
          foreach ($permissoes as $permissao) {
            $novasPermissoes[$permissao->nomeHtml] = $permissao;
          }

            return response()->json([
                'token' => $this->jwt($usuario),
                'id' => $usuario->usuario,
                'primeiroLogin' => $usuario->primeiroLogin,
                'categoriaUsuario' => $usuario->categoriaUsuario,
                'permissoes' => $novasPermissoes
            ], 200);
        }
        // Bad Request response
        return response()->json([
          'message' => 'Dados inválidos, logon negado.'
        ], 401);
    }

    public function isLogged(Usuario $usuario) {
      $token = $this->request->input('token');
      try {
        $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
      } catch(ExpiredException $e) {
          return response()->json([
              'error' => 'Token está expirado.'
          ], 400);
      } catch(Exception $e) {
          return response()->json([
              'error' => 'Ocorreu um erro ao decodificar o token.'
          ], 400);
      }

      $usuario = Usuario::where('login', $credentials->login)->first();
      $permissoes = PermissoesModuloController::lista($credentials->cat);
      $novasPermissoes = [];
      foreach ($permissoes as $permissao) {
        $novasPermissoes[$permissao->nomeHtml] = $permissao;
      }

      return response()->json([
          'token' => $this->jwt($usuario),
          'id' => $usuario->usuario,
          'login' => $usuario->login,
          'primeiroLogin' => $usuario->primeiroLogin,
          'categoriaUsuario' => $usuario->categoriaUsuario,
          'permissoes' => $novasPermissoes
      ], 200);
  }
}
