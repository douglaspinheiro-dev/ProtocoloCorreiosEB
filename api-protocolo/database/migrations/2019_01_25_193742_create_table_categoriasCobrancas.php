<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoriasCobrancas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categoriasCobrancas', function (Blueprint $table) {
        $table->increments('categoriaCobranca');
        $table->string('descricao');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('status');
        $table->boolean('ativo');
        $table->decimal('valor');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('categoriasCobrancas');
    }
}
