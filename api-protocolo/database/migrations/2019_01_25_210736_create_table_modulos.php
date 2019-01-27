<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('modulos', function (Blueprint $table) {
        $table->increments('modulo');
        $table->string('descricao');
        $table->string('cadastro');
        $table->integer('categoriaModulo');
        $table->string('identificador');
        $table->boolean('abrir');
        $table->boolean('gravar');
        $table->boolean('alterar');
        $table->boolean('excluir');
        $table->boolean('relatorios');
        $table->string('nomeHtml');
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
      Schema::drop('modulos');
    }
}
