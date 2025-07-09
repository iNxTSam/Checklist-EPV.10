<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USUARIOS extends Model
{
    protected $table = 'Usuarios';
    protected $primaryKey= 'idUsarios';
    protected $connection= 'mysql'; 
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
}
