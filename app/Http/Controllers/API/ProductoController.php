<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function series($producto)
    {
        $producto = Producto::find($producto);
        if(!$producto) {
            return response()->json([]);
        }

        $series = $producto->series()->select('series.id', 'series.nombre')->get()->makeHidden('pivot');  
        
        return response()->json($series);
    }

    public function virsualizar($producto, $serie)
    {
        $producto = Producto::find($producto);
        if (!$producto) {
            return response()->json([]);
        }

        $serie = $producto->series()->where('serie_id', $serie)->first();
        if (!$serie) {
            return response()->json([]);
        }
        
        return response()->json([
            'producto_id' => $serie->pivot->producto_id,
            'serie_id' => $serie->pivot->serie_id,
            'descripcion' => $serie->pivot->descripcion,
            'imagen' => $serie->pivot->imagen,
        ]);
    }
}
