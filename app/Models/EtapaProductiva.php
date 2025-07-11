<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapaProductiva extends Model
{
    protected $table = 'EtapaProductiva';
    protected $primaryKey = 'idEtapaProductvia';
    public $timestamps = false;

    public function gestionEvidencias()
    {
        return $this->belongsTo(GestionEvidencias::class, 'GestionEvidencias_idGestionEvidencias');
    }
}
