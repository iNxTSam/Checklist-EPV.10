<?php

use App\Http\Controllers\AuthPersonalizadoController;
use Illuminate\Support\Facades\Route;

// Ruta principal redirige a la vista de aprendiz
Route::get('/', function () {
    return redirect()->route('vista.instructor');
});

// Vistas principales
Route::view('/aprendiz', 'Aprendiz')->name('vista.aprendiz');
Route::view('/instructor', 'Instructor')->name('vista.instructor');

// Rutas que procesan los formularios
Route::post('/login-aprendiz', [AuthPersonalizadoController::class, 'loginAprendiz'])->name('login.aprendiz');
Route::post('/login-instructor', [AuthPersonalizadoController::class, 'loginInstructor'])->name('login.instructor');

// Rutas de bienvenida
Route::get('/bienvenido-aprendiz', function () {
    return 'Bienvenido Aprendiz';
})->name('bienvenido.aprendiz');

Route::get('/bienvenido-instructor', function () {
    return 'Bienvenido Instructor';
})->name('bienvenido.instructor');
