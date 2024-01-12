<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("codigo", 255)->unique();
            $table->string("gestion_ingreso", 155);
            $table->string("tipo_ingreso", 255);
            $table->date("fecha_baja");
            $table->date("fecha_item");
            $table->text("descripcion")->nullable();
            $table->text("observaciones")->nullable();
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("user_id")->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
