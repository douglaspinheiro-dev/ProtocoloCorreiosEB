<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProtocoloEntradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocoloEntradas', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('protocolo');
            $table->integer('anoCadastro', 4);
            $table->string('protocoloEntrada', 32)->unique();
            $table->string('identificador');
            $table->integer('categoriaDocumento');
            $table->string('numero');
            $table->date('dataDocumento');
            $table->date('dataCadastro');
            $table->string('origem');
            $table->integer('setor');
            $table->string('assunto');
            $table->boolean('enderecoCadastrado');
            $table->integer('usuarioCriador');
            $table->integer('usuarioAlterador');
            $table->boolean('ativo');
            $table->primary(['anoCadastro', 'protocolo', 'protocoloEntrada']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('protocoloEntradas');
    }
}
