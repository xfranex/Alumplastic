<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carpinteria extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }
}
