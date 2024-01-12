<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("documento_id");
            $table->unsignedBigInteger("funcionario_id");
            $table->integer("cantidad_documentos");
            $table->date("fecha");
            $table->time("hora");
            $table->text("descripcion");
            $table->text("observacion");
            $table->date("fecha_registro");
            $table->timestamps();
            $table->foreign("documento_id")->on("documentos")->references("id");
            $table->foreign("funcionario_id")->on("funcionarios")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolucion_documentos');
    }
}
