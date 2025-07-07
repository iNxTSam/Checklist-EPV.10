<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // nombre de la tabla

    protected $fillable = [
        'nombre',
        'numero_documento',
        'password',
        'rol'
    ];

    protected $hidden = ['password'];
}

