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
        Schema::create('gestionRutas', function (Blueprint $table) {
            $table->id('idGestionRutas') ;
            $table->string('formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva') -> nullable();
            $table->string('comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena') -> nullable();
            $table->string('pazYSalvoAcademicoAdministrativo') -> nullable();
            $table->string('fotocopiaDocumentoDeIdentidad') -> nullable();
            $table->string('certificadoAprobacionEmpresaTerminacionEtapaProductiva') -> nullable();
            $table->string('certificadoAsistenciaPruebaSaberTTIcfes') -> nullable();
            $table->string('formatoEntregaDeDocumentos') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_rutas');
    }
};
