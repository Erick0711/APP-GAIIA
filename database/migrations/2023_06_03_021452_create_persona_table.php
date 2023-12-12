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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_pers', 100);
            $table->string('apellido_pers', 100);
            $table->string('ci_pers', 10);
            $table->string('complemento_ci_pers', 5)->nullable();
            $table->string('correo_pers', 191);
            $table->date('fecha_nac_pers', 10);
            $table->string('telefono_pers', 20);
            $table->string('telefono2_pers', 20);
            $table->tinyInteger('estado_pers')->default(1);
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
        Schema::dropIfExists('persona');
    }
};
