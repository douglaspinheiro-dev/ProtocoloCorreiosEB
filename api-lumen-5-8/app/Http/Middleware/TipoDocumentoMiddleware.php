<?php

namespace App\Http\Middleware;

use Closure;
use App\ChromePhp;
use App\Http\Controllers\ValidaPermissoesController;

class TipoDocumentoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $permissoes = new ValidaPermissoesController($request);
      $method = $request->method();
      if ($method == 'GET') {
        $permissao = $permissoes->abrir('tipoDocumento');
      } else if ($method == 'POST') {
        $permissao = $permissoes->inserir('tipoDocumento');
      } else if ($method == 'PUT') {
        $permissao = $permissoes->alterar('tipoDocumento');
      } else if ($method == 'DELETE') {
        $permissao = $permissoes->excluir('tipoDocumento');
      }

      if ($permissao) {
        return $next($request);
      } else {
        return response()->json([
          'error' => 'Seu grupo de usuario não tem permissao para esta operacao'
        ], 403);
      }
    }
}
