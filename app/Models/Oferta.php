<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentario',
        'producto_id',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id','id');
    }
}
