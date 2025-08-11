<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = "horarios";

    protected $fillable = [
        "tipo",
        "mensaje_vacaciones",
        'hora_mañana',
        'hora_tarde',
        'mensaje_laboral',
        'activo',
    ];

    public function esLaboral(): bool
    {
        return $this->tipo === 'laboral';
    }

    public function esVacaciones(): bool
    {
        return $this->tipo === 'vacaciones';
    }
}
