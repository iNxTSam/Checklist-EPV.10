<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Navegacion;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\InstructorController;


Route::get('/', function () {
    return view('index');
});

Route::get('/aprendizLogin', [Navegacion::class, 'aprendiz']);
Route::get('/instructorLogin', [Navegacion::class, 'instructor']);
Route::get('/sample', [Navegacion::class, 'documentos']);

// Rutas Instructor
Route::get('/buscarFicha', [InstructorController::class, 'buscarFicha'])->name('instructor.buscarFicha');
Route::get('/buscarFicha/resultado', [InstructorController::class, 'verFicha'])->name('ficha.buscar');
Route::get('/instructor/revision/{id}', [InstructorController::class, 'reviewStudent'])->name('instructor.revision');
Route::post('/instructor/revision/{id}/guardar', [InstructorController::class, 'guardarRevision'])->name('instructor.guardarRevision');

// Rutas Aprendiz
Route::get('/aprendiz', [AprendizController::class, 'aprendiz'])->name('aprendiz.inicio');
Route::post('/aprendiz/subir', [AprendizController::class, 'subirDocumentos'])->name('aprendiz.subir');
