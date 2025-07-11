<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'Roles';
    protected $primaryKey = 'idRoles';
    public $timestamps = false;


    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Roles_idRoles');
    }
}
