<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionRutas extends Model
{
    use HasFactory;
    protected $table = 'GestionRutas';
    protected $primaryKey = 'idGestionRutas';
    public $timestamps = false;

    protected $fillable = [
        'idGestionRutas',
        'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
        'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
        'pazYSalvoAcademicoAdministrativo',
        'fotocopiaDocumentoDeIdentidad',
        'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
        'certificadoAsistenciaPruebaSaberTTIcfes',
        'formatoEntregaDeDocumentos',
    ];

   
}