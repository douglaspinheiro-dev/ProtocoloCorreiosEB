<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

class CorrespondenciaDao extends Dao
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
      return DB::select("SELECT
        correspondencia,
        protocolo,
        anoCadastro,
        numeroDocumento,
        codigoRastreio,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro,
        destino,
        setores.codigo as setorDescricao
        FROM correspondencias
        JOIN categoriasDocumentos on correspondencias.categoriaDocumento = categoriasDocumentos.categoriaDocumento
        JOIN setores on correspondencias.setor = setores.setor
        AND
      (
        correspondencias.protocolo LIKE '%{$obj['busca']}%' OR
        correspondencias.codigoRastreio LIKE '%{$obj['busca']}%' OR
        correspondencias.numeroDocumento LIKE '%{$obj['busca']}%'
      )
      AND correspondencias.ativo = 1 ORDER BY correspondencias.dataCadastro desc LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT *,
        categoriaDocumento as tipoDocumento,
        categoriaCorrespondencia as tipoCorrespondencia,
        categoriaCobranca as tipoCobranca
        FROM correspondencias WHERE correspondencia = '{$id}' AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE correspondencias SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE correspondencia = '{$dados['id']}'");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO correspondencias
      (
        correspondencia,
        anoCadastro,
        numeroDocumento,
        dataCadastro,
        categoriaDocumento,
        setor,
        destino,
        enderecoCadastrado,
        codigoRastreio,
        usuarioCriador,
        categoriaCorrespondencia,
        categoriaCobranca,
        valorTotal,
        bairro,
        cep,
        cidade,
        complemento,
        logradouro,
        numero,
        referencia,
        uf,
        remetente,
      ) values
      (
        '{$dados['correspondencia']}',
        '{$dados['anoCadastro']}',
        '{$dados['numeroDocumento']}',
        '{$dados['dataCadastro']}',
        '{$dados['tipoDocumento']}',
        '{$dados['setor']}',
        '{$dados['destino']}',
        '{$dados['enderecoCadastrado']}',
        '{$dados['codigoRastreio']}',
        '{$dados['usuarioCriador']}',
        '{$dados['tipoCorrespondencia']}',
        '{$dados['tipoCobranca']}',
        '{$dados['valorTotal']}',
        '{$dados['bairro']}',
        '{$dados['cep']}',
        '{$dados['cidade']}',
        '{$dados['complemento']}',
        '{$dados['logradouro']}',
        '{$dados['numero']}',
        '{$dados['referencia']}',
        '{$dados['uf']}',
        '{$dados['remetente']}'
      )");
    }

    public static function altera($dados) {
      return DB::update("UPDATE correspondencias SET
      numeroDocumento = '{$dados['numeroDocumento']}',
      dataCadastro = '{$dados['dataCadastro']}',
      categoriaDocumento = '{$dados['tipoDocumento']}',
      setor = '{$dados['setor']}',
      destino = '{$dados['destino']}',
      enderecoCadastrado = '{$dados['enderecoCadastrado']}',
      codigoRastreio = '{$dados['codigoRastreio']}',
      usuarioCriador = '{$dados['usuarioCriador']}',
      categoriaCorrespondencia = '{$dados['tipoCorrespondencia']}',
      categoriaCobranca = '{$dados['tipoCobranca']}',
      valorTotal = '{$dados['valorTotal']}',
      bairro = '{$dados['bairro']}',
      cep = '{$dados['cep']}',
      cidade = '{$dados['cidade']}',
      complemento = '{$dados['complemento']}',
      logradouro = '{$dados['logradouro']}',
      numero = '{$dados['numero']}',
      referencia = '{$dados['referencia']}',
      uf = '{$dados['uf']}',
      remetente = '{$dados['remetente']}',
      usuarioAlterador = '{$dados['usuarioAlterador']}'
      where correspondencia = '{$dados['correspondencia']}'");
    }

    //
}
