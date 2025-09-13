<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fichas', function (Blueprint $table) {
            $table->bigIncrements("idFichas");
            $table->integer("NumeroDeFicha");
            $table->integer("TipoDeJornada_idTipoDeJornada");
            $table->integer("TipoDeFormacion_idTipoDeFormacion");
            $table->integer("FechasFormacion_idFechasFormacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha');
    }
};
