<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionRutas extends Model
{
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

    public function estado()
    {
        return $this->belongsTo(EstadoDocumentacion::class, 'EstadoDocumentacion_idEstadoEtapa');
    }
}