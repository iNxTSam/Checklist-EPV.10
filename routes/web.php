<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Navegacion;
use App\Http\Controllers\Instructor;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AuthPersonalizadoController;
use App\Http\Controllers\Prueba;

// Vista index portal
Route::get('/', function () {
    return view('index');
});

// Sample de Instructor o Aprendiz
Route::get ('/sample', [Navegacion::class, 'documentos'])->name('login');

// Vista instructor
Route::get ('/instructorLogin', [Navegacion::class, 'instructor'])->name('vista.instructor');
Route::get ('/buscarFicha', [Instructor::class, 'buscar'])->name('buscarficha')->middleware('auth');
Route::get ('/instructor', [PortalController::class, 'instructor'])->name('instructor.instructor')->middleware('auth');
Route::get ('/instructor/student/{id}', [PortalController::class, 'reviewStudent'])->name('instructor.review')->middleware('auth');

// Vista aprendiz 
Route::get ('/aprendizLogin', [Navegacion::class, 'aprendiz'])->name('vista.aprendiz');
Route::get ('/aprendiz', [PortalController::class, 'aprendiz'])->middleware('auth');

// Rutas que procesan los formularios
Route::post('/login-aprendiz', [AuthPersonalizadoController::class, 'loginAprendiz'])->name('login.aprendiz');
Route::post('/login-instructor', [AuthPersonalizadoController::class, 'loginInstructor'])->name('login.instructor');
Route::post('/logout', [AuthPersonalizadoController::class, 'logout'])->name('logout');
Route::get('/usuarios', [Prueba::class, 'index']);
