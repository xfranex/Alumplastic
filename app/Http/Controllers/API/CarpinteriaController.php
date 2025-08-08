<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Producto;

class CarpinteriaController extends Controller
{
    public function carpinterias()
    {
        $carpinterias = Carpinteria::select('id', 'nombre')->has('productos')->get();
        
        if($carpinterias->isEmpty()) {
            return response()->json([
                ['nombre' => '...']
            ]);
        }

        return response()->json($carpinterias);
    }

    public function productos($carpinteria)
    {
        $existe = Carpinteria::where('id', $carpinteria)->exists();
        if(!$existe) {
            return response()->json([]);
        }

        $productos = Producto::where('carpinteria_id', $carpinteria)->select('id','nombre')->get();
        
        return response()->json($productos);
    }
}
