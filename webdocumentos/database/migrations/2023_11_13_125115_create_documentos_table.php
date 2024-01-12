<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string("codigo", 155)->unique();
            $table->text("descripcion");
            $table->unsignedBigInteger("dependencia_id");
            $table->unsignedBigInteger("funcionario_id");
            $table->unsignedBigInteger("oficina_id");
            $table->unsignedBigInteger("estante_id");
            $table->integer("nivel");
            $table->integer("division");
            $table->string("estado");
            $table->date("fecha");
            $table->time("hora");
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
        Schema::dropIfExists('documentos');
    }
}
