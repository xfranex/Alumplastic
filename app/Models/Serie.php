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

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
