<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Navegacion extends Controller
{
    public function aprendiz(){
        return view ('login/Aprendiz');
    }
    public function instructor(){
        return view ('login/Instructor');
    }
    public function documentos(){
        return view ('sample/index');
    }
}
