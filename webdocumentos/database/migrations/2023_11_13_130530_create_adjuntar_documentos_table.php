<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjuntarDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntar_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("documento_id");
            $table->string("archivo", 255);
            $table->string("ext", 100);
            $table->string("tipo");
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
        Schema::dropIfExists('adjuntar_documentos');
    }
}
