<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;


class USUARIOS extends Authenticatable
{

    use Notifiable;
    use HasFactory;
    
    protected $table = 'Usuarios';
    protected $primaryKey = 'idUsuarios';
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
     public function descripcionEvidencias()
    {
        return $this->hasMany(DescripcionEvidencias::class, 'gestionevidencias_idGestionEvidencias');
    }
        public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'Fichas_idFichas');
    }
        public function rol()
    {
        return $this->belongsTo(Rol::class, 'Roles_idRoles');
    }
    public function fichasAsignadas()
{
    return $this->belongsToMany(Ficha::class, 'instructorficha', 'idInstructor', 'idFicha');
}
}
