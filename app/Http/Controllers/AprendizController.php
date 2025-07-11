<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\ComentariosDocumento;


class AprendizController extends Controller
{
    protected $usuario_id = 1030556208; 

public function aprendiz()
{
    $usuario = Usuario::with('etapaProductiva.gestionEvidencias')->findOrFail($this->usuario_id);
    $evidencias = $usuario->etapaProductiva->gestionEvidencias;

    $comentarios = ComentariosDocumento::where('idUsuario', $this->usuario_id)->get()->keyBy('nombreDocumento');

    $documentos = [
        ['campo' => 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva', 'nombre' => 'Formato: Planeación, seguimiento y evaluación Etapa Productiva (F-023 Final)'],
        ['campo' => 'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena', 'nombre' => 'Comprobante inscripción Agencia Pública de Empleo SENA'],
        ['campo' => 'pazYSalvoAcademicoAdministrativo', 'nombre' => 'Paz y Salvo Académico Administrativo'],
        ['campo' => 'fotocopiaDocumentoDeIdentidad', 'nombre' => 'Fotocopia documento de identidad'],
        ['campo' => 'certificadoAprobacionEmpresaTerminacionEtapaProductiva', 'nombre' => 'Certificado aprobación empresa (terminación etapa productiva)'],
        ['campo' => 'certificadoAsistenciaPruebaSaberTTIcfes', 'nombre' => 'Certificado de asistencia prueba Saber TyT - CEET'],
        ['campo' => 'formatoEntregaDeDocumentos', 'nombre' => 'Formato entrega de documentos'],
    ];

    $docsConDatos = [];
    foreach ($documentos as $doc) {
        $contenido = $evidencias->{$doc['campo']};
        $ruta = $contenido ? asset('storage/' . $contenido) : null;

        $comentario = $comentarios[$doc['campo']] ?? null;
        $estado = $comentario->estado ?? 'pendiente';

        $docsConDatos[] = [
            'name'     => $doc['nombre'],
            'field'    => $doc['campo'],
            'exists'   => !empty($contenido),
            'approved' => $estado === 'aprobado',
            'rejected' => $estado === 'rechazado',
            'comment'  => $comentario->comentario ?? 'Sin comentarios',
            'ruta'     => $ruta,
        ];
    }

    return view('aprendiz.aprendiz', [
        'usuario' => $usuario,
        'documentos' => $docsConDatos
    ]);
}



public function subirDocumentos(Request $request)
{
    $usuario = Usuario::with('etapaProductiva.gestionEvidencias')->findOrFail($this->usuario_id);
    $evidencias = $usuario->etapaProductiva->gestionEvidencias;

    $campos = [
        'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
        'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
        'pazYSalvoAcademicoAdministrativo',
        'fotocopiaDocumentoDeIdentidad',
        'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
        'certificadoAsistenciaPruebaSaberTTIcfes',
        'formatoEntregaDeDocumentos'
    ];

    $data = [];

    foreach ($campos as $campo) {
        if ($request->hasFile($campo)) {
            $file = $request->file($campo);

            if (
                $file->isValid() &&
                $file->getClientOriginalExtension() === 'pdf' &&
                $file->getSize() <= 5 * 1024 * 1024
            ) {
                $filename = $this->usuario_id . '_' . $campo . '.pdf';
                $path = $file->storeAs('documents', $filename, 'public');

 
                $data[$campo] = $path;

     
                ComentariosDocumento::updateOrCreate(
                    [
                        'idUsuario' => $this->usuario_id,
                        'nombreDocumento' => $campo
                    ],
                    [
                        'estado' => 'pendiente',
                        'comentario' => null
                    ]
                );
            }
        }
    }

    if (!empty($data)) {
        $evidencias->update($data);
    }

    return redirect()->route('aprendiz.inicio')->with('success', 'Documentos enviados correctamente');
}
}
