<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('descripcion', 'imagen')->withTimestamps();
    }
}
