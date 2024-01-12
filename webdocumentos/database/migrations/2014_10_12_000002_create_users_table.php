<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->unique();
            $table->string("nombre", 255);
            $table->string("paterno", 255);
            $table->string("materno", 255)->nullable();
            $table->string("ci", 40);
            $table->string("ci_exp", 20);
            $table->string("dir", 255)->nullable();
            $table->string("correo", 255)->nullable();
            $table->string("fono", 255)->nullable();
            $table->enum("tipo", ["ADMINISTRADOR", "FUNCIONARIO"]);
            $table->string("foto", 255)->nullable();
            $table->string('password');
            $table->integer("acceso");
            $table->date("fecha_registro");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
