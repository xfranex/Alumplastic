<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'producto_id'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('nombre', 'descripcion', 'imagen')->withTimestamps();
    }
}
