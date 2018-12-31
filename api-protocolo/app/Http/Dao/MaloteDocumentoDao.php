<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class MaloteDocumentoDao extends Dao
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
      return DB::select("SELECT
        maloteDocumentos.*,
        maloteDocumentos.categoriaDocumento as tipoDocumento,
        enderecos.codigoReduzido,
        enderecos.descricao as enderecoDescricao,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        setores.descricao as setorDescricao
    FROM maloteDocumentos
    JOIN rotasEnderecos ON maloteDocumentos.rotaEndereco = rotasEnderecos.rotaEndereco
    JOIN enderecos ON enderecos.endereco = rotasEnderecos.endereco
    JOIN categoriasDocumentos ON categoriasDocumentos.categoriaDocumento = maloteDocumentos.categoriaDocumento
    JOIN setores ON setores.setor = maloteDocumentos.setor
    AND maloteDocumentos.malote = {$id} ORDER BY maloteDocumentos.maloteDocumento desc");
    }

    public static function seleciona($id) {
      return DB::select("SELECT
        maloteDocumento,
        malote,
        categoriaDocumento as tipoDocumento,
        numero,
        setor,
        rotaEndereco
        FROM maloteDocumentos WHERE maloteDocumento = {$id}");
    }

    public static function apaga($id) {
      return DB::delete("DELETE FROM maloteDocumentos WHERE maloteDocumento = {$id}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO maloteDocumentos (malote, categoriaDocumento, numero, setor, rotaEndereco, usuarioCriador) values ('{$dados['malote']}','{$dados['tipoDocumento']}','{$dados['numero']}', '{$dados['setor']}','{$dados['rotaEndereco']}',{$dados['usuarioCriador']})");
    }

    public static function altera($dados) {
      return DB::update("UPDATE maloteDocumentos SET
        categoriaDocumento = '{$dados['tipoDocumento']}',
        numero = '{$dados['numero']}',
        setor = '{$dados['setor']}',
        rotaEndereco = '{$dados['rotaEndereco']}',
        usuarioAlterador = '{$dados['usuarioAlterador']}'
        WHERE maloteDocumento = {$dados['maloteDocumento']}");
    }

}
