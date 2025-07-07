<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Navegacion extends Controller
{
    public function aprendiz(){
        return view ('sample/loginAprendiz');
    }
    public function instructor(){
        return view ('sample/loginInstructor');
    }
    public function documentos(){
        return view ('sample/index');
    }
}
