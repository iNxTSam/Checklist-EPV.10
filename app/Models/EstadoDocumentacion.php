<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoDocumentacion extends Model
{
    protected $table = 'EstadoDocumentacion';
    protected $primaryKey = 'idEstadoEtapa';
    public $timestamps = false;
}