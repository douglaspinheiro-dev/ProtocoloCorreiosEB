<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMalotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('malotes', function (Blueprint $table) {
        $table->engine = 'MyISAM';
        $table->increments('protocolo');
        $table->integer('anoCadastro', 4);
        $table->string('malote', 32)->unique();
        $table->date('data');
        $table->integer('rota');
        $table->integer('numeroBolsa');
        $table->string('lacre');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
        $table->boolean('ativo');
        $table->primary(['anoCadastro', 'protocolo', 'malote']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('malotes');
    }
}
