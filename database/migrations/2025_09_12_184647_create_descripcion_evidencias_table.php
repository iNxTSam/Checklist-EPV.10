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
        Schema::create('descripcionEvidencias', function (Blueprint $table) {
            $table->id('idDescripcion');
            $table->integer('idUsuario');
            $table->string('nombreDocumento');
            $table->text('comentario')->nullable();
            $table->string('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descripcion_evidencias');
    }
};
