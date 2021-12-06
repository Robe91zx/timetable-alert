<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    use HasFactory;

    const ADMINISTRATION_COLUMNS = [
        '0' => 'Nombre',
        '1' => 'Permisos Asignados'
    ];

    const ADMINISTRATION_OPTIONS = [
        '1' =>'Crear Rol',
        '2' =>'Crear Permiso',
        '3' =>'Modificar permisos'
       
    ];
}
