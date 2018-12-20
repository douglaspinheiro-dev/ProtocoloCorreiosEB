<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class RotaEnderecoDao extends Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public static function lista($id) {
      return DB::select("SELECT rotasEnderecos.*, enderecos.* FROM rotasEnderecos
      JOIN enderecos ON rotasEnderecos.endereco = enderecos.endereco AND
      rotasEnderecos.rota = {$id} ORDER BY rotasEnderecos.endereco");
    }

    public static function seleciona($id) {
      return DB::select("SELECT * FROM rotasEnderecos WHERE rota = {$id}");
    }

    public static function apaga($dados) {
      return DB::update("DELETE FROM rotasEnderecos WHERE rotaEndereco = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO rotasEnderecos (endereco, rota, usuarioCriador) values ('{$dados['endereco']}','{$dados['rota']}', {$dados['usuarioCriador']})");
    }

}
