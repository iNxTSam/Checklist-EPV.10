<?php

namespace App\Http\Controllers;

use App\Models\USUARIOS;

class Prueba extends Controller
{
    public function index(){
        $usuarios = USUARIOS::create([
    'idUsuarios' => 1234567,
    'Nombres' => 'Juan',
    'Apellidos' => 'Pérez',
    'Telefono' => 1234567890,
    'Correo' => 'juana@example.com',
    'Clave' => bcrypt('clave123'),
    'Dirrecion' => 'Mi dirección',
    'TipoDeDocumentos_idTipoDeDocumentos' => 1,
    'Roles_idRoles' => 3,
    'Fichas_idFichas' => 1,
    'EtapaProductvia_idEtapaProductvia' => 1
]);
        return response()->json($usuarios);
    }
    
}
