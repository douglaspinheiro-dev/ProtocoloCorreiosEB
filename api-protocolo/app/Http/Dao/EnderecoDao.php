<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class EnderecoDao extends Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public static function lista($obj) {
      return DB::select("SELECT endereco, descricao,codigoReduzido,usuarioCriador FROM enderecos WHERE
      (
        descricao LIKE '%{$obj['busca']}%' OR
        codigoReduzido LIKE '%{$obj['busca']}%' OR
        codigo LIKE '%{$obj['busca']}%'
      )
      AND ativo = 1 ORDER BY descricao LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT * FROM enderecos WHERE endereco = '{$id}' AND ativo = 1");
    }

    public static function selecionaEnderecoPorCodigo($id) {
      return DB::select("SELECT * FROM enderecos WHERE codigoReduzido LIKE '%{$id}%' AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE enderecos SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE endereco = {$dados['id']}");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO enderecos
      (
        descricao,
        codigo,
        codigoReduzido,
        logradouro,
        numero,
        complemento,
        bairro,
        cidade,
        uf,
        cep,
        referencia,
        status,
        malote,
        usuarioCriador
      ) values
      (
        '{$dados['descricao']}',
        '{$dados['codigo']}',
        '{$dados['codigoReduzido']}',
        '{$dados['logradouro']}',
        '{$dados['numero']}',
        '{$dados['complemento']}',
        '{$dados['bairro']}',
        '{$dados['cidade']}',
        '{$dados['uf']}',
        '{$dados['cep']}',
        '{$dados['referencia']}',
        '{$dados['status']}',
        '{$dados['malote']}',
        '{$dados['usuarioCriador']}'
      )");
    }

    public static function altera($dados) {
      return DB::update("UPDATE enderecos SET
      descricao = '{$dados['descricao']}',
      codigo = '{$dados['codigo']}',
      codigoReduzido = '{$dados['codigoReduzido']}',
      logradouro = '{$dados['logradouro']}',
      numero = '{$dados['numero']}',
      complemento = '{$dados['complemento']}',
      bairro = '{$dados['bairro']}',
      cidade = '{$dados['cidade']}',
      uf = '{$dados['uf']}',
      cep = '{$dados['cep']}',
      referencia = '{$dados['referencia']}',
      status = '{$dados['status']}',
      malote = '{$dados['malote']}',
      usuarioCriador = '{$dados['usuarioCriador']}'
      where endereco = {$dados['endereco']}");
    }

    public static function options() {
      return DB::select("SELECT endereco, descricao,codigoReduzido,usuarioCriador FROM enderecos WHERE ativo = 1 ORDER BY descricao");
    }

    public static function optionsRota() {
      return DB::select("SELECT endereco, descricao,codigoReduzido,usuarioCriador FROM enderecos WHERE ativo = 1 AND malote = 1 ORDER BY descricao");
    }

    //
}
