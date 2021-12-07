<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department_hasCarreer extends Model
{
    use HasFactory;
    protected $fillable = ['department_vcode','carreer_vcode'];

    const DEPARTMENT_CARREERS_COLUMNS = [
        '0' =>'DEPARTAMENTO',
        '1' =>'Carrera',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];
}
