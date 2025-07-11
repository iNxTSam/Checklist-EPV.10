<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentariosDocumento extends Model
{
    protected $table = 'ComentariosDocumento';

    protected $primaryKey = 'idComentario';

    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'nombreDocumento',
        'comentario',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuarios');
    }
}
