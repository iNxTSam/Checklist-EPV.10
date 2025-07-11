<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Navegacion;
use App\Http\Controllers\Instructor;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\InstructorController;


Route::get('/', function () {
    return view('index');
});

Route::get ('/aprendizLogin', [Navegacion::class, 'aprendiz']);

Route::get ('/instructorLogin', [Navegacion::class, 'instructor']);

Route::get ('/sample', [Navegacion::class, 'documentos']);

Route::get ('/buscarFicha', [Instructor::class, 'buscar']);

Route::get('/instructor', [InstructorController::class, 'instructor'])->name('instructor.instructor');

Route::get('/instructor/revision/{id}', [InstructorController::class, 'reviewStudent'])->name('instructor.revision');



Route::post('/instructor/revision/{id}/guardar', [InstructorController::class, 'guardarRevision'])->name('instructor.guardarRevision');



Route::get('/aprendiz', [AprendizController::class, 'aprendiz'])->name('aprendiz.inicio');
Route::post('/aprendiz/subir', [AprendizController::class, 'subirDocumentos'])->name('aprendiz.subir');
