<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTableCorrespondencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::raw('CREATE TABLE correspondencias (
        anoCadastro int(4) NOT NULL,
        protocolo bigint(20) NOT NULL AUTO_INCREMENT,
        correspondencia varchar(32) NOT NULL,
        categoriaDocumento bigint(20) NOT NULL,
        numeroDocumento varchar(255) NOT NULL,
        setor bigint(20) NOT NULL,
        destino varchar(255) NOT NULL,
        enderecoCadastrado tinyint(4) NOT NULL DEFAULT 0,
        valorTotal decimal(8,2) NOT NULL,
        usuarioCriador bigint(20) NOT NULL,
        usuarioAlterador bigint(20) DEFAULT NULL,
        ativo tinyint(4) NOT NULL DEFAULT 1,
        dataCadastro date NOT NULL,
        codigoRastreio varchar(45) DEFAULT NULL,
        logradouro varchar(150) DEFAULT NULL,
        numero varchar(150) DEFAULT NULL,
        complemento varchar(60) DEFAULT NULL,
        bairro varchar(60) DEFAULT NULL,
        cidade varchar(60) DEFAULT NULL,
        uf varchar(2) DEFAULT NULL,
        cep varchar(9) DEFAULT NULL,
        referencia varchar(255) DEFAULT NULL,
        categoriaCorrespondencia bigint(20) NOT NULL,
        categoriaCobranca bigint(20) NOT NULL,
        remetente varchar(255) DEFAULT NULL,
        PRIMARY KEY (anoCadastro,protocolo,correspondencia)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('correspondencias');
    }
}
