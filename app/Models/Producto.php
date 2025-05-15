<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_producto_id',
    ];

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id', 'id');
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'producto_id', 'id');
    }
}
