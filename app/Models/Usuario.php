<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // nombre de la tabla

    protected $fillable = [
        'Nombres',
        'Apellidos',
        'Clave',
        'Roles_idRoles'
    ];

    protected $hidden = ['password'];
}

