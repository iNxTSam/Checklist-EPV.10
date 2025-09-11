<?php

namespace App\Http\Controllers;

use App\Models\USUARIOS;
use Illuminate\Http\Request;
use App\Models\DescripcionEvidencias;
use Illuminate\Support\Facades\Auth;
use App\Models\GestionRutas;

class AprendizController extends Controller
{
    public function aprendiz()
    {
        $usuario = Auth::user();


        $comentarios = DescripcionEvidencias::where('idUsuario', $usuario->idUsuarios)
            ->get()
            ->keyBy('nombreDocumento');


        $evidencias = GestionRutas::where('idGestionRutas', $usuario->idUsuarios)->first();


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
            $campo = $doc['campo'];
            $contenido = $evidencias?->{$campo};
            $ruta = $contenido ? asset('storage/' . $contenido) : null;

            $comentario = $comentarios[$campo] ?? null;
            $estado = $comentario?->estado ?? 'Pendiente'; 

            $docsConDatos[] = [
                'name' => $doc['nombre'],
                'field' => $campo,
                'exists' => !empty($contenido),
                'approved' => strtolower($estado) === 'aprobado',
                'rejected' => strtolower($estado) === 'rechazado',
                'comment' => $comentario->comentario ?? 'Sin comentarios',
                'estado' => $estado,
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

        $msg = null;
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
                            'estado' => 'Pendiente'
                        ]
                    );
                }
                else{
                    $msg = "Por favor asegurese que los archivos estan en PDF y pesan menos de 5 MB";
                    return redirect()->route('aprendiz.inicio')->with('msg', $msg);
                }
            }
        }

        if (!empty($data)) {
            GestionRutas::updateOrCreate(
                ['idGestionRutas' => $usuario->idUsuarios],
                $data
            );
        }

        return redirect()->route('aprendiz.inicio')->with('success', 'Documentos enviados correctamente')->with('msg', $msg);
    }
}
