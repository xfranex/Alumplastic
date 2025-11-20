<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'imagen',
        'carpinteria_id'
    ];

    //un trabajo pertenece a una carpintería
    public function carpinteria()
    {
        return $this->belongsTo(Carpinteria::class);
    }
}
