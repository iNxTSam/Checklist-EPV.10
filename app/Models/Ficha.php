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
}