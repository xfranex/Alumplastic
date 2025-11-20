<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'nombre',
    ];

    //una serie puede tener muchos productos y un producto puede pertenecer a muchas series, los campos adicionales están en la tabla pivote
    //dependiendo de la serie y el producto tendrán una descripción y una imagen en concreto
    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('descripcion', 'imagen')->withTimestamps();
    }
}
