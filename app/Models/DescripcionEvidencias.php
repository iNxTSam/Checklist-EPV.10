<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DescripcionEvidencias extends Model
{
    protected $table = 'descripcionEvidencias';
    protected $primaryKey = 'idDescripcion';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'nombreDocumento',
        'comentario',
        'estado',
    ];

    public function gestionRutas()
    {
        return $this->hasOne(GestionRutas::class, 'idGestionRutas', 'idUsuario');
    }

    public function usuario()
    {
        return $this->belongsTo(USUARIOS::class, 'idUsuario', 'idUsuarios');
    }

}
