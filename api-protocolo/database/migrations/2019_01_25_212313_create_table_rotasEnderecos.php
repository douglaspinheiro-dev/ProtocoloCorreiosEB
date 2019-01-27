<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRotasEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rotaEnderecos', function (Blueprint $table) {
        $table->increments('rotaEndereco');
        $table->integer('rota');
        $table->integer('endereco');
        $table->integer('usuarioCriador');
        $table->integer('usuarioAlterador');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('rotaEnderecos');
    }
}
