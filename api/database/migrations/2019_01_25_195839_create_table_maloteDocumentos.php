<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaloteDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('maloteDocumentos', function (Blueprint $table) {
        $table->increments('maloteDocumento');
        $table->string('malote');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->integer('categoriaDocumento');
        $table->integer('setor');
        $table->integer('rotaEndereco');
        $table->string('numero');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('maloteDocumentos');
    }
}
