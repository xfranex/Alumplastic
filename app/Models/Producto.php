<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'nombre',
        'carpinteria_id'
    ];

    //un producto pertenece a una carpintería
    public function carpinteria()
    {
        return $this->belongsTo(Carpinteria::class);
    }

    //un producto puede pertenecer a muchas series se incluye en la tabla pivote información adicional como la descripción y la imagen y los timestamps
    public function series()
    {
        return $this->belongsToMany(Serie::class)->withPivot('descripcion', 'imagen')->withTimestamps();
    }
}
