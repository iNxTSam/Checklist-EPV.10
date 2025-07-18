<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\USUARIOS;
use App\Models\Ficha;
use App\Models\descripcionEvidencias;
use App\Models\gestionRutas;

class InstructorController extends Controller
{
    public function buscarFicha()
    {
        return view('instructor.buscarFicha');
    }

    public function verFicha(Request $request)
    {
        $numero = $request->input('ficha');
        $instructorId = 3123123; 

        $ficha = Ficha::with(['usuarios.ficha'])
            ->where('NumeroDeFicha', $numero)
            ->first();

        if (!$ficha) {
            return redirect()->route('instructor.buscarFicha')->with('mensaje', 'Ficha no encontrada');
        }

        $asignada = DB::table('instructorficha')
            ->where('idInstructor', $instructorId)
            ->where('idFicha', $ficha->idFichas)
            ->exists();

        if (!$asignada) {
            return redirect()->route('instructor.buscarFicha')->with('mensaje', 'No tienes acceso a esta ficha');
        }

        $aprendices = $ficha->usuarios
            ->where('Roles_idRoles', 2)
            ->map(function ($usuario) {
                return (object)[
                    'idUsuarios' => $usuario->idUsuarios,
                    'Nombres' => $usuario->Nombres,
                    'Apellidos' => $usuario->Apellidos,
                    'ficha' => $usuario->ficha,
                    'estado' => $this->getEstadoGeneral($usuario),
                ];
            });

        return view('instructor.instructor', [
            'aprendices' => $aprendices,
            'fichaNumero' => $numero
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

        $user = USUARIOS::findOrFail($id);
        $ruta = gestionRutas::where('idGestionRutas', $id)->first();

        $documents = collect($documentos)->map(function ($doc, $index) use ($ruta, $user) {
            $file = $ruta?->{$doc['campo']};

            $descripcion = descripcionEvidencias::where('idUsuario', $user->idUsuarios)
                ->where('nombreDocumento', $doc['campo'])
                ->first();

            $estado = $descripcion?->estado ?? 'Pendiente';
            $comentario = $descripcion?->comentario ?? '';

            return [
                'id' => $index + 1,
                'name' => $doc['nombre'],
                'campo' => $doc['campo'],
                'comment' => $comentario,
                'estado' => $estado,
                'approved' => $estado === 'Aprobado',
                'rejected' => $estado === 'Rechazado',
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
        $fichaNumero = $request->input('ficha');

        foreach ($comentarios as $nombre => $comentario) {
            $estadoInput = $estados[$nombre] ?? 'pending';


            $estado = match (strtolower($estadoInput)) {
                'approved' => 'Aprobado',
                'rejected' => 'Rechazado',
                default => 'Pendiente',
            };

            descripcionEvidencias::updateOrCreate(
                ['idUsuario' => $id, 'nombreDocumento' => $nombre],
                ['comentario' => $comentario, 'estado' => $estado]
            );
        }

        return redirect()->route('ficha.buscar', ['ficha' => $fichaNumero])
            ->with('success', 'Revisión guardada correctamente.');
    }

    private function getEstadoGeneral($usuario)
    {
        $documentos = descripcionEvidencias::where('idUsuario', $usuario->idUsuarios)->get();

        if ($documentos->isEmpty()) return 'Pendiente';

        $estados = $documentos->pluck('estado');

        if ($estados->contains('Rechazado')) {
            return 'Rechazado';
        } elseif ($estados->contains('Pendiente') || $estados->contains(null)) {
            return 'Pendiente';
        }

        return 'Aprobado';
    }
}
