<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Navegacion;
use App\Http\Controllers\Instructor;
use App\Http\Controllers\PortalController;


Route::get('/', function () {
    return view('index');
});

Route::get ('/aprendizLogin', [Navegacion::class, 'aprendiz']);

Route::get ('/instructorLogin', [Navegacion::class, 'instructor']);

Route::get ('/sample', [Navegacion::class, 'documentos']);

Route::get ('/buscarFicha', [Instructor::class, 'buscar']);

Route::get ('/instructor', [PortalController::class, 'instructor'])->name('instructor.instructor');;

Route::get ('/instructor/student/{id}', [PortalController::class, 'reviewStudent'])->name('instructor.review');;
Route::get ('/aprendiz', [PortalController::class, 'aprendiz'])->name('aprendiz.aprendiz');;
