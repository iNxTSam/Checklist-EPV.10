<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorFicha extends Model
{
    protected $table = 'instructorficha';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['idInstructor', 'idFicha'];

    public function instructor()
    {
        return $this->belongsTo(USUARIOS::class, 'idInstructor');
    }

        public function ficha()
        {
            return $this->belongsTo(Ficha::class, 'idFicha', 'idFichas');
        }


    
}
