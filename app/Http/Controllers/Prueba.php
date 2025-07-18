<?php

namespace App\Http\Controllers;

use App\Models\USUARIOS;
use App\Models\DescripcionEvidencias;
use App\Models\GestionRutas;

class Prueba extends Controller
{
    public function index()
    {
        $id = 654654;
        $usuarios = USUARIOS::create([
            'idUsuarios' => $id,
            'Nombres' => 'Juan',
            'Apellidos' => 'Rey',
            'Telefono' => 3131234567,
            'Correo' => 'juan@sena.edu.co',
            'Clave' => bcrypt('clave123'),
            'Dirrecion' => 'Mi dirección',
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1
        ]);
        $contador = 0;
        $nombres = [
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'pazYSalvoAcademicoAdministrativo',
            'fotocopiaDocumentoDeIdentidad',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'certificadoAsistenciaPruebaSaberTTIcfes',
            'formatoEntregaDeDocumentos'
        ];
        do {
            $descripcionEvidencias = DescripcionEvidencias::create([
                'idUsuario' => $id,
                'estadodocumentacion_idEstadoEtapa' => 1,
                'nombreDocumento' => $nombres[$contador],
                'comentario' => null,
                $contador++
            ]);
        } while ($contador <= 6);

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

        return response()->json([$usuarios, $descripcionEvidencias, $gestionRutas]);
    }

}
