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
        numero,
        categoriasDocumentos.descricao as tipoDocumentoDescricao,
        DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro,
        destino,
        setores.codigo as setorDescricao
        FROM correspondencias
        JOIN categoriasDocumentos on correspondencias.categoriaDocumento = categoriasDocumentos.categoriaDocumento
        JOIN setores on correspondencias.setor = setores.setor
        AND
      (
        correspondencias.numero LIKE '%{$obj['busca']}%' OR
        correspondencias.correspondencia LIKE '%{$obj['busca']}%'
      )
      AND correspondencias.ativo = 1 ORDER BY correspondencias.dataCadastro desc LIMIT {$obj['inicio']}, {$obj['fim']}");
    }

    public static function seleciona($id) {
      return DB::select("SELECT *, categoriaDocumento as tipoDocumento FROM correspondencias WHERE correspondencia = '{$id}' AND ativo = 1");
    }

    public static function apaga($dados) {
      return DB::update("UPDATE correspondencias SET ativo = 0, usuarioAlterador = {$dados['usuarioAlterador']} WHERE correspondencia = '{$dados['id']}'");
    }

    public static function salva($dados) {
      return DB::insert("INSERT INTO correspondencias
      (
        correspondencia,
        anoCadastro,
        numero,
        dataCadastro,
        categoriaDocumento,
        origem,
        setor,
        enderecoCadastrado,
        usuarioCriador
      ) values
      (
        '{$dados['correspondencia']}',
        '{$dados['anoCadastro']}',
        '{$dados['numero']}',
        '{$dados['dataCadastro']}',
        '{$dados['tipoDocumento']}',
        '{$dados['origem']}',
        '{$dados['setor']}',
        '{$dados['assunto']}',
        '{$dados['enderecoCadastrado']}',
        '{$dados['usuarioCriador']}'
      )");
    }

    public static function altera($dados) {
      return DB::update("UPDATE correspondencias SET
      numero = '{$dados['numero']}',
      dataCadastro = '{$dados['dataCadastro']}',
      categoriaDocumento = '{$dados['tipoDocumento']}',
      origem = '{$dados['origem']}',
      setor = '{$dados['setor']}',
      enderecoCadastrado = '{$dados['enderecoCadastrado']}',
      usuarioAlterador = '{$dados['usuarioAlterador']}'
      where correspondencia = '{$dados['correspondencia']}'");
    }

    //
}
