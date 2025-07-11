<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'idUsuarios';
    public $timestamps = false;


    public function etapaProductiva()
    {
        return $this->belongsTo(EtapaProductiva::class, 'EtapaProductvia_idEtapaProductvia');
    }

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'Fichas_idFichas');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'Roles_idRoles');
    }
}
