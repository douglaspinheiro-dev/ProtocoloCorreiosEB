<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoriasUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categoriasUsuarios', function (Blueprint $table) {
        $table->increments('categoriaUsuario');
        $table->string('descricao');
        $table->string('codigo');
        $table->string('editavel');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
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
      Schema::drop('categoriasUsuarios');
    }
}
