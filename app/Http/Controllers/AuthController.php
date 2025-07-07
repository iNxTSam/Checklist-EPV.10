<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login'); // Muestra la vista del formulario login
    }

    public function login(Request $request)
    {
        $request->validate([
            'numero_documento' => 'required|numeric',
            'password' => 'required',
        ]);

        // Buscar el usuario por documento
        $usuario = Usuario::where('numero_documento', $request->numero_documento)->first();

        // Depuración: no se encontró el documento
        if (!$usuario) {
            return back()->withErrors([
                'numero_documento' => 'No se encontró un usuario con ese número de documento.'
            ]);
        }

        // Depuración: la contraseña no coincide
        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors([
                'numero_documento' => 'La contraseña es incorrecta.'
            ]);
        }

        // Autenticar al usuario
        Auth::login($usuario);

        // Redirigir según el rol
        if ($usuario->rol === 'aprendiz') {
            return redirect()->route('aprendiz');
        } elseif ($usuario->rol === 'instructor') {
            return redirect()->route('instructor');
        } else {
            Auth::logout();
            return redirect('/login')->withErrors([
                'rol' => 'El rol asignado al usuario no es válido.'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
