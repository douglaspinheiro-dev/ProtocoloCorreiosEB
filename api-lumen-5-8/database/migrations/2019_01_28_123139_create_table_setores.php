<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSetores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('setores', function (Blueprint $table) {
        $table->increments('setor');
        $table->string('codigo');
        $table->string('codigoReduzido');
        $table->string('descricao');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('status');
        $table->boolean('ativo');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('setores');
    }
}
