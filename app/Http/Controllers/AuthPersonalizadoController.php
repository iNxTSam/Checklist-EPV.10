<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\USUARIOS;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthPersonalizadoController extends Controller
{
    public function loginAprendiz(Request $request)
    {
        $usuario = USUARIOS::where('idUsuarios', $request->numeroDocumento)
                          ->where('Roles_idRoles', '2')
                          ->first();

        if ($usuario && Hash::check($request->clave, $usuario->Clave)) {
            Auth::login($usuario);
            $request->session()->regenerate();
            return redirect()->intended('aprendiz');
        }

        return redirect()->route('vista.aprendiz')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }

    public function loginInstructor(Request $request)
    {
        $usuario = USUARIOS::where('idUsuarios', $request->numeroDocumento)
                          ->where('Roles_idRoles', '1')
                          ->first();

        if ($usuario && Hash::check($request->clave, $usuario->Clave)) {
            Auth::login($usuario);
            $request->session()->regenerate();
            return redirect()->intended('instructor');
        }

        return redirect()->route('vista.instructor')->withErrors(['error' => 'Documento o contraseña incorrectos']);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
