<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'description', 'duration', 'vcode', 'carreer_vcode', 'state'];

    public function subjects(){
        return $this->hasMany(Subject::class, 'id');
    }
//indico la clave foranea
    public function carreers(){
        return $this->belongsTo(Carreer::class, 'carreer_vcode', 'vcode');
    }

    const CURRICULUMS_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'CARRERA',
        '2' => 'MALLA',
        '3' => 'ESTADO'
    ];

    const CURRICULUMS_OPTIONS = [
        '1' =>'Agregar Malla',

    ];
}
