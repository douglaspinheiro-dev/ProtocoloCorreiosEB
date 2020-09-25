<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\DB;


class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token nao fornecido. Deve logar'
            ], 401);
        }
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
        // $usuario = Usuario::find($credentials->sub);
        $usuario = DB::select("SELECT categoriaUsuario, login, nome, usuario FROM usuarios where usuario = {$credentials->sub}");
        // Now let's put the usuario in the request class so that you can grab it from there
        $request->auth = $usuario;
        $request->usuario = $usuario[0];
        return $next($request);
    }
}
