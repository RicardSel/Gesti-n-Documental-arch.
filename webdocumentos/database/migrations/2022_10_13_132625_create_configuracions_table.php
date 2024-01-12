<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_sistema", 255);
            $table->string("alias", 255)->nullable();
            $table->string("razon_social", 255);
            $table->string("ciudad", 255);
            $table->string("dir", 255);
            $table->string("fono", 255);
            $table->string("web", 255)->nullable();
            $table->string("actividad", 255)->nullable();
            $table->string("correo", 255)->nullable();
            $table->string("logo", 255)->nullable();
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
        Schema::dropIfExists('configuracions');
    }
}
