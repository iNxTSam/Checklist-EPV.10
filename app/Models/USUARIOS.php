<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class USUARIOS extends Authenticatable
{

    use Notifiable;
    protected $table = 'Usuarios';
    protected $primaryKey = 'idUsuarios';
    protected $connection = 'mysql';
    public $incrementing = false;
    protected $fillable = [
        'idUsuarios',
        'Nombres',
        'Apellidos',
        'Telefono',
        'Correo',
        'Clave',
        'Dirrecion',
        'TipoDeDocumentos_idTipoDeDocumentos',
        'Roles_idRoles',
        'Fichas_idFichas',
        'EtapaProductvia_idEtapaProductvia'
    ];
    public $timestamps = false;
    public $hidden = ['Clave'];

    public function getAuthPassword()
    {
        return $this->Clave;
    }

}
