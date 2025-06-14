<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'carpinteria_id'
    ];

    public function carpinteria()
    {
        return $this->belongsTo(Carpinteria::class);
    }

    public function series()
    {
        return $this->belongsToMany(Serie::class)->withPivot('descripcion', 'imagen')->withTimestamps();
    }
}
