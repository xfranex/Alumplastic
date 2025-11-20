<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carpinteria extends Model
{
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'nombre',
    ];

    //una carpintería puede tener múltiples productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    //una carpintería puede tener múltiples trabajos
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }
}
