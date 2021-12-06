<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyCarreer extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_vcode','carreer_vcode'];

    const FACULTY_CARREERS_COLUMNS = [
        '0' =>'Facultad',
        '1' =>'Carrera',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];
}
