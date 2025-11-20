<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'mensaje',
    ];
}
