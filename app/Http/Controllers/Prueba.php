<?php

namespace App\Http\Controllers;

use App\Models\USUARIOS;
use App\Models\DescripcionEvidencias;
use App\Models\GestionRutas;

class Prueba extends Controller
{
    public function index()
    {
        $id = 3123123;


        $usuarios = USUARIOS::create([
            'idUsuarios' => $id,
            'Nombres' => 'uwu',
            'Apellidos' => 'Rey',
            'Telefono' => 3131234567,
            'Correo' => 'juan@sena.edu.co',
            'Clave' => bcrypt('clave123'),
            'Dirrecion' => 'Mi dirección',
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 1,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1
        ]);

        $nombres = [
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'pazYSalvoAcademicoAdministrativo',
            'fotocopiaDocumentoDeIdentidad',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'certificadoAsistenciaPruebaSaberTTIcfes',
            'formatoEntregaDeDocumentos'
        ];

        $descripcionEvidencias = [];

        foreach ($nombres as $nombre) {
            $descripcionEvidencias[] = DescripcionEvidencias::create([
                'idUsuario' => $id,
                'nombreDocumento' => $nombre,
                'comentario' => null,
                'estado' => 'pendiente' 
            ]);
        }

 
        $gestionRutas = GestionRutas::create([
            'idGestionRutas' => $id,
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva' => null,
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena' => null,
            'pazYSalvoAcademicoAdministrativo' => null,
            'fotocopiaDocumentoDeIdentidad' => null,
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva' => null,
            'certificadoAsistenciaPruebaSaberTTIcfes' => null,
            'formatoEntregaDeDocumentos' => null,
        ]);

        return response()->json([
            'usuario' => $usuarios,
            'descripcionEvidencias' => $descripcionEvidencias,
            'gestionRutas' => $gestionRutas
        ]);
    }
}
