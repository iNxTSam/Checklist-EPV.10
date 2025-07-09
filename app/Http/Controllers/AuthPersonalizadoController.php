<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\USUARIOS;
use Illuminate\Support\Facades\Hash;

class AuthPersonalizadoController extends Controller
{
    public function loginAprendiz(Request $request)
    {
        $usuario = USUARIOS::where('idUsuarios', $request->numero_documento)
                          ->where('Roles_idRoles', '3')
                          ->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            return redirect()->route('bienvenido.aprendiz');
        }

        return redirect()->route('vista.aprendiz')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }

    public function loginInstructor(Request $request)
    {
        $usuario = USUARIOS::where('idUsuarios', $request->numero_documento)
                          ->where('Roles_idRoles', '2')
                          ->first();

        if ($usuario && Hash::check($request->password, $usuario->Clave)) {
            return redirect()->route('bienvenido.instructor');
        }

        return redirect()->route('vista.instructor')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }
}
