<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCorrespondencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('correspondencias', function (Blueprint $table) {
        $table->engine = 'MyISAM';
        $table->increments('protocolo');
        $table->integer('anoCadastro', 4);
        $table->string('correspondencia', 32)->unique();
        $table->integer('categoriaDocumento');
        $table->string('numeroDocumento');
        $table->integer('setor');
        $table->string('destino');
        $table->boolean('enderecoCadastrado');
        $table->decimal('valorTotal');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('ativo');
        $table->date('dataCadastro');
        $table->string('codigoRastreio');
        $table->string('logradouro');
        $table->string('numero');
        $table->string('complemento');
        $table->string('bairro');
        $table->string('cidade');
        $table->string('uf', 2);
        $table->string('cep');
        $table->string('referencia');
        $table->integer('categoriaCorrespondencia');
        $table->integer('categoriaCobranca');
        $table->string('remetente');
        $table->primary(['anoCadastro', 'protocolo', 'correspondencia']);
      });
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
