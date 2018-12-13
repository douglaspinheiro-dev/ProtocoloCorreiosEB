<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class PermissoesModuloController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function lista($id) {
      $results = DB::select(
        "SELECT
          permissoesModulos.*,
          modulos.nomeHtml
        FROM permissoesModulos
        join modulos on modulos.modulo = permissoesModulos.modulo
        and permissoesModulos.categoriaUsuario = {$id}");
      return $results;
    }

    //
}
