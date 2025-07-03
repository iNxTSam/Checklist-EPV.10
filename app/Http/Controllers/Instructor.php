<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Instructor extends Controller
{
    public function buscar(){
        return view ('instructor/buscarFicha');
    }
}
