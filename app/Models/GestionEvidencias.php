<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionEvidencias extends Model
{
    protected $table = 'GestionEvidencias';
    protected $primaryKey = 'idGestionEvidencias';
    public $timestamps = false;

    protected $fillable = [
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
