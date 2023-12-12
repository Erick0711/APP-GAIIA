<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_cargo');
            $table->foreign('id_persona')->references('id')->on('persona');
            $table->foreign('id_cargo')->references('id')->on('cargo');
            $table->string('fecha_ingreso_soc');
            $table->tinyInteger('estado_soc')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('socio');
    }
};
