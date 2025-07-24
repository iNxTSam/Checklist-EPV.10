<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Navegacion;
use App\Http\Controllers\Instructor;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AuthPersonalizadoController;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Prueba;

// Vista index portal
Route::get('/', function () {
    return view('index');
})->name('index');

// Sample de Instructor o Aprendiz
Route::get('/sample', [Navegacion::class, 'documentos'])->name('login');

// Vista instructor
Route::middleware(['auth', 'role:1', 'no-cache'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/', [InstructorController::class, 'buscarFicha'])->name('buscarFicha');
    Route::get('/buscarFicha/resultado', [InstructorController::class, 'verFicha'])->name('ficha.buscar');
    Route::get('/instructor/revision/{id}', [InstructorController::class, 'reviewStudent'])->name('revision');
    Route::post('/instructor/revision/{id}/guardar', [InstructorController::class, 'guardarRevision'])->name('guardarRevision');
});

Route::get('/instructorLogin', [Navegacion::class, 'instructor'])->name('vista.instructor');

// Vista aprendiz 
Route::middleware(['auth', 'role:2', 'no-cache'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('/', [AprendizController::class, 'aprendiz'])->name('inicio');
    Route::post('/subir', [AprendizController::class, 'subirDocumentos'])->name('subir');
});
Route::get('/aprendizLogin', [Navegacion::class, 'aprendiz'])->name('vista.aprendiz');


// Rutas que procesan los formularios
Route::post('/login-aprendiz', [AuthPersonalizadoController::class, 'loginAprendiz'])->name('login.aprendiz');
Route::post('/login-instructor', [AuthPersonalizadoController::class, 'loginInstructor'])->name('login.instructor');
Route::post('/logout', [AuthPersonalizadoController::class, 'logout'])->name('logout');

Route::get('/usuarios', [Prueba::class, 'index']);
