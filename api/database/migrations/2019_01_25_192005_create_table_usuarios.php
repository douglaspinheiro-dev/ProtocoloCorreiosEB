<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('usuarios', function (Blueprint $table) {
        $table->increments('usuario');
        $table->string('nome');
        $table->string('login')->unique();
        $table->string('password');
        $table->integer('categoriaUsuario');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('primeiroLogin');
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
      Schema::drop('usuarios');
    }
}
