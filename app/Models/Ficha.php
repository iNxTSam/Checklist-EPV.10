<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    protected $table = 'Fichas'; 
    protected $primaryKey = 'idFichas'; 
    public $timestamps = false;

  
    public function usuarios()
    {
        return $this->hasMany(USUARIOS::class, 'Fichas_idFichas');
    }

    public function aprendices()
{
    return $this->hasMany(USUARIOS::class, 'Fichas_idFichas')->where('Roles_idRoles', 2); // Solo aprendices
}

public function instructores()
{
    return $this->belongsToMany(USUARIOS::class, 'instructorficha', 'idFicha', 'idInstructor');
}
    
}