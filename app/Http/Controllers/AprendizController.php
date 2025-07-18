<?php

namespace App\Http\Controllers;



use App\Models\USUARIOS;
use Illuminate\Http\Request;
use App\Models\DescripcionEvidencias;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionRutas;
use App\Models\EtapaProductiva;

class AprendizController extends Controller
{

    public function aprendiz()
    {
        $usuario = Auth::user();


        $comentarios = DescripcionEvidencias::where('idUsuario', $usuario->idUsuarios)->get()->keyBy('nombreDocumento');

        // Obtener la evidencia y sus rutas asociadas
        $evidencia = DescripcionEvidencias::where('idUsuario', $usuario->idUsuarios)->first();
        $evidencias = $evidencia?->gestionRutas;

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

            $contenido = $evidencias?->{$doc['campo']};   
                $ruta = null;
                $ruta = $contenido ? asset('storage/' . $contenido) : null;
            
            $comentario = $comentarios[$doc['campo']] ?? null;
            $estado = $comentario?->estadodocumentacion_idEstadoEtapa ?? 1;

            $docsConDatos[] = [
                'name' => $doc['nombre'],
                'field' => $doc['campo'],
                'exists' => !empty($contenido),
                'approved' => $estado === 2,
                'rejected' => $estado === 3,
                'comment' => $comentario->comentario ?? 'Sin comentarios',
                'ruta' => $ruta,
            ];
        }

        return view('aprendiz.aprendiz', [
            'usuario' => $usuario,
            'documentos' => $docsConDatos
        ]);
    }



    public function subirDocumentos(Request $request)
    {

        $campos = [
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'pazYSalvoAcademicoAdministrativo',
            'fotocopiaDocumentoDeIdentidad',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'certificadoAsistenciaPruebaSaberTTIcfes',
            'formatoEntregaDeDocumentos'
        ];

        $usuario = Auth::user();
        if (!$usuario) {

            return redirect()->route('vista.aprendiz')->with('error', 'Debe iniciar sesión para subir documentos.');
        }

        $evidencia = DescripcionEvidencias::where('idUsuario', $usuario->idUsuarios)->first();
        $evidencias = $evidencia?->gestionRutas;
        $data = [];

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {
                $file = $request->file($campo);

                if (
                    $file->isValid() &&
                    $file->getClientOriginalExtension() === 'pdf' &&
                    $file->getSize() <= 5 * 1024 * 1024
                ) {
                    $filename = $usuario->idUsuarios . '_' . $campo . '.pdf';
                    $path = $file->storeAs('documents', $filename, 'public');


                    $data[$campo] = $path;


                    DescripcionEvidencias::updateOrCreate(
                        [
                            'idUsuario' => $usuario->idUsuarios,
                            'nombreDocumento' => $campo
                        ],
                        [
                            'comentario' => null,
                            'estadodocumentacion_idEstadoEtapa' => 1

                        ]
                    );
                }
            }
        }

        if (!empty($data)) {
            $gestionRuta = $evidencia?->gestionRutas;

            GestionRutas::updateOrCreate(
                ['idGestionRutas' => $usuario->idUsuarios],
                $data
            );
        }

        return redirect()->route('aprendiz.inicio')->with('success', 'Documentos enviados correctamente');
    }
}