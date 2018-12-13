<?php

namespace App\Http\Dao;
use Illuminate\Support\Facades\DB;

class RegistroDao
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

    public static function confere($dados) {

      if (array_key_exists("campo2", $dados)) {
        $dados['campo2'] = 'and ' . $dados['campo2'] . ' = ' . $dados['valor2'];
      } else {
        $dados['campo2'] = '';
      }

      if (array_key_exists("campo3", $dados)) {
        $dados['campo3'] = 'and ' . $dados['campo3'] . ' = ' . $dados['valor3'];
      } else {
        $dados['campo3'] = '';
      }

      return DB::select("SELECT * FROM {$dados['tabela']} WHERE {$dados['campo']} = '{$dados['valor']} {$dados['campo2']} {$dados['campo3']}'");
    }

    //
}
