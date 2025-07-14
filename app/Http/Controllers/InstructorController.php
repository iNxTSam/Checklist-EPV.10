<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{   
        public function buscarFicha()
    {
        return view('instructor.buscarFicha');
    }

    public function verFicha(Request $request)
    {
        $numero = $request->input('ficha');

        $ficha = \App\Models\Ficha::with(['usuarios.etapaProductiva.gestionEvidencias', 'usuarios.ficha'])
                    ->where('NumeroDeFicha', $numero)
                    ->first();

        if ($ficha) {
            $aprendices = $ficha->usuarios
                ->where('Roles_idRoles', 2) // Solo aprendices
                ->map(function ($usuario) {
                    return (object)[
                        'idUsuarios' => $usuario->idUsuarios,
                        'Nombres' => $usuario->Nombres,
                        'Apellidos' => $usuario->Apellidos,
                        'ficha' => $usuario->ficha,
                        'estado' => $this->getEstadoGeneral($usuario),
                    ];
                });

            return view('instructor.instructor', ['aprendices' => $aprendices]);
        }

        return redirect()->route('instructor.buscarFicha')->with('mensaje', 'Ficha no encontrada');
    }

    public function instructor()
    {
        $instructorId = 1234567890;

        $fichas = DB::table('InstructorFicha')
            ->where('idInstructor', $instructorId)
            ->pluck('idFicha');

        $usuarios = Usuario::where('Roles_idRoles', 2)
            ->whereIn('Fichas_idFichas', $fichas)
            ->with('ficha', 'etapaProductiva.gestionEvidencias')
            ->get();

        $students = collect();

        foreach ($usuarios as $user) {
            $students->push((object)[
                'idUsuarios' => $user->idUsuarios,
                'Nombres' => $user->Nombres,
                'Apellidos' => $user->Apellidos,
                'ficha' => $user->ficha,
                'estado' => $this->getEstadoGeneral($user),
            ]);
        }

        if ($students->isEmpty()) {
            $students->push((object)[
                'idUsuarios' => 1030556208,
                'Nombres' => 'Aprendiz',
                'Apellidos' => 'Ejemplo',
                'ficha' => (object)['NumeroDeFicha' => '123456'],
                'estado' => 'Pendiente',
            ]);
        }

        return view('instructor.instructor', [
            'aprendices' => $students
        ]);
    }

    public function reviewStudent($id)
    {
        $documentos = [
            ['campo' => 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva', 'nombre' => 'Formato: Planeación, seguimiento y evaluación Etapa Productiva (F-023 Final)'],
            ['campo' => 'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena', 'nombre' => 'Comprobante inscripción Agencia Pública de Empleo SENA'],
            ['campo' => 'pazYSalvoAcademicoAdministrativo', 'nombre' => 'Paz y Salvo Académico Administrativo'],
            ['campo' => 'fotocopiaDocumentoDeIdentidad', 'nombre' => 'Fotocopia documento de identidad'],
            ['campo' => 'certificadoAprobacionEmpresaTerminacionEtapaProductiva', 'nombre' => 'Certificado aprobación empresa (terminación etapa productiva)'],
            ['campo' => 'certificadoAsistenciaPruebaSaberTTIcfes', 'nombre' => 'Certificado de asistencia prueba Saber TyT - CEET'],
            ['campo' => 'formatoEntregaDeDocumentos', 'nombre' => 'Formato entrega de documentos'],
        ];

        $user = Usuario::with('etapaProductiva.gestionEvidencias')->find($id);
        if (!$user) abort(404, 'Aprendiz no encontrado');

        $evidencias = $user->etapaProductiva?->gestionEvidencias;

        $documents = collect($documentos)->map(function ($doc, $index) use ($evidencias, $user) {
            $file = $evidencias?->{$doc['campo']};

            $comentarioData = DB::table('ComentariosDocumento')
                ->where('idUsuario', $user->idUsuarios)
                ->where('nombreDocumento', $doc['campo'])
                ->first();

            return [
                'id' => $index + 1,
                'name' => $doc['nombre'],
                'campo' => $doc['campo'],
                'comment' => $comentarioData?->comentario,
                'estado' => $comentarioData?->estado ?? 'pendiente',
                'approved' => $comentarioData?->estado === 'aprobado',
                'rejected' => $comentarioData?->estado === 'rechazado',
                'file_path' => $file ? asset("storage/{$file}") : null,
                'uploaded_at' => $file ? now() : null,
            ];
        });

        $student = [
            'id' => $user->idUsuarios,
            'name' => "{$user->Nombres} {$user->Apellidos}",
            'document' => $user->idUsuarios,
            'program' => 'Tecnología en Electrónica',
            'submitted_at' => now(),
        ];

        return view('instructor.review', compact('student', 'documents'));
    }

    public function guardarRevision(Request $request, $id)
    {
        $comentarios = $request->input('comentarios', []);
        $estados = $request->input('estados', []);
        $fichaNumero = $request->input('ficha'); // <-- capturar ficha

        foreach ($comentarios as $nombre => $comentario) {
            $estado = $estados[$nombre] ?? 'pendiente';

            DB::table('ComentariosDocumento')->updateOrInsert(
                ['idUsuario' => $id, 'nombreDocumento' => $nombre],
                ['comentario' => $comentario, 'estado' => $estado]
            );
        }

        return redirect()->route('ficha.buscar', ['ficha' => $fichaNumero])
            ->with('success', 'Revisión guardada');
    }


    private function getEstadoGeneral($user)
    {
        $documentos = [
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'pazYSalvoAcademicoAdministrativo',
            'fotocopiaDocumentoDeIdentidad',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'certificadoAsistenciaPruebaSaberTTIcfes',
            'formatoEntregaDeDocumentos'
        ];

        $aprobados = 0;
        $rechazados = 0;

        foreach ($documentos as $doc) {
            $estado = DB::table('ComentariosDocumento')
                ->where('idUsuario', $user->idUsuarios)
                ->where('nombreDocumento', $doc)
                ->value('estado');

            if ($estado === 'aprobado') {
                $aprobados++;
            } elseif ($estado === 'rechazado') {
                $rechazados++;
            }
        }

        if ($aprobados === count($documentos)) return 'Aprobado';
        if ($rechazados > 0) return 'Rechazado';
        return 'Pendiente';
    }
}
