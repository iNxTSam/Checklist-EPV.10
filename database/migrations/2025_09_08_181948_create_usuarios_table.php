<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements("idUsuarios");
            $table->string("Nombres");
            $table->string("Apellidos");
            $table->string("Telefono");
            $table->string("Correo");
            $table->string("Clave");
            $table->string("Dirrecion");
            $table->integer("TipoDeDocumentos_idTipoDeDocumentos");
            $table->integer("Roles_idRoles");
            $table->integer("Fichas_idFichas");
            $table->integer("EtapaProductvia_idEtapaProductvia");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
