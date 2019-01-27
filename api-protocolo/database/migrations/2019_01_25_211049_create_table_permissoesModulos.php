<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePermissoesModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('permissoesModulos', function (Blueprint $table) {
        $table->increments('permissaoModulo');
        $table->boolean('abrir');
        $table->boolean('inserir');
        $table->boolean('alterar');
        $table->boolean('excluir');
        $table->boolean('relatorios');
        $table->integer('categoriaUsuario');
        $table->integer('modulo');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('permissoesModulos');
    }
}
