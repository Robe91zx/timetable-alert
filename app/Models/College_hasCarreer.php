<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College_hasCarreer extends Model
{
    use HasFactory;
    protected $fillable = ['college_vcode','carreer_vcode'];

    const COLLEGE_CARREERS_COLUMNS = [
        '0' =>'Escuela',
        '1' =>'Carrera',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];
}
