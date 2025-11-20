<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //nombre de la tabla asociada al modelo
    protected $table = "horarios";

    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        "tipo",
        "mensaje_vacaciones",
        'hora_mañana',
        'hora_tarde',
        'mensaje_laboral',
        'activo',
    ];

    //determina si es horario laboral
    public function esLaboral(): bool
    {
        return $this->tipo === 'laboral';
    }

    //determina si es horario vacacional
    public function esVacaciones(): bool
    {
        return $this->tipo === 'vacaciones';
    }
}
