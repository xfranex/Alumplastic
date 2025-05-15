<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajoRealizado extends Model
{
    use HasFactory;
    protected $table = 'trabajos_realizados';

    protected $fillable = [
        'imagen_url',
        'tipo_producto_id',
    ];

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id', 'id');
    }
}
