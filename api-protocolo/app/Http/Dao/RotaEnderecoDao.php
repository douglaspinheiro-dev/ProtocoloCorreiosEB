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

    public static function selecionaEndereco($id) {
      return DB::select("SELECT * FROM rotasEnderecos WHERE endereco = {$id}");
    }

    public static function apaga($id) {
      return DB::delete("DELETE FROM rotasEnderecos WHERE rotaEndereco = {$id}");
    }

    public static function apagaEndereco($id) {
      return DB::delete("DELETE FROM rotasEnderecos WHERE endereco = {$id}");
    }

    public static function salva($dados) {
      DB::delete("DELETE FROM rotasEnderecos WHERE endereco = {$dados['endereco']}");
      return DB::insert("INSERT INTO rotasEnderecos (endereco, rota, usuarioCriador) values ('{$dados['endereco']}','{$dados['rota']}', {$dados['usuarioCriador']})");
    }

    public static function options($rota) {
      return DB::select("SELECT rotasEnderecos.*, enderecos.descricao,enderecos.codigoReduzido FROM rotasEnderecos
        JOIN enderecos ON enderecos.endereco = rotasEnderecos.endereco AND rotasEnderecos.rota = {$rota}");
    }

}
