<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthPersonalizadoController extends Controller
{
    public function loginAprendiz(Request $request)
    {
        $usuario = Usuario::where('numero_documento', $request->numero_documento)
                          ->where('rol', 'aprendiz')
                          ->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            return redirect()->route('bienvenido.aprendiz');
        }

        return redirect()->route('vista.aprendiz')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }

    public function loginInstructor(Request $request)
    {
        $usuario = Usuario::where('numero_documento', $request->numero_documento)
                          ->where('rol', 'instructor')
                          ->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            return redirect()->route('bienvenido.instructor');
        }

        return redirect()->route('vista.instructor')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }
}
