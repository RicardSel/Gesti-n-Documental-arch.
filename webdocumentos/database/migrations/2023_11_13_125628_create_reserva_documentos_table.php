<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("documento_id");
            $table->unsignedBigInteger("funcionario_id");
            $table->text("descripcion");
            $table->text("observacion");
            $table->date("fecha");
            $table->time("hora");
            $table->date("fecha_registro");
            $table->timestamps();
            
            $table->foreign("documento_id")->on("documentos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva_documentos');
    }
}
