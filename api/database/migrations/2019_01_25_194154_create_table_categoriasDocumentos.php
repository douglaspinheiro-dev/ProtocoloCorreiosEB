<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoriasDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categoriasDocumentos', function (Blueprint $table) {
        $table->increments('categoriaDocumento');
        $table->string('descricao');
        $table->string('codigo');
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
      Schema::drop('categoriasDocumentos');
    }
}
