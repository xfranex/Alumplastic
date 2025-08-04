<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function series($id)
    {
        $producto = Producto::find($id);
        $series = $producto->series()->select('series.id', 'series.nombre')->get();  
        return response()->json($series);
    }
}
