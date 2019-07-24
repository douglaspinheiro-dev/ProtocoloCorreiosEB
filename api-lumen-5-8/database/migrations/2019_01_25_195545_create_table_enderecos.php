<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('enderecos', function (Blueprint $table) {
        $table->increments('endereco');
        $table->string('codigo');
        $table->string('codigoReduzido');
        $table->string('descricao');
        $table->string('logradouro');
        $table->string('numero');
        $table->string('complemento');
        $table->string('bairro');
        $table->string('cidade');
        $table->string('uf', 2);
        $table->string('cep');
        $table->string('referencia');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('status');
        $table->boolean('ativo');
        $table->boolean('malote');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('enderecos');
    }
}
