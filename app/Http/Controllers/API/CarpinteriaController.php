<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Producto;

class CarpinteriaController extends Controller
{
    /**
     * Lista las carpinterías
     */
    public function carpinterias()
    {
        $carpinterias = Carpinteria::select('id', 'nombre')->has('productos')->get(); //obtiene las carpinterías que tiene productos seleccionando el id y el nombre
        
        if($carpinterias->isEmpty()) { //si se encuentra vacío entonces responde un JSON con puntos suspensivos esto lo veremos cuando esté todo vacío sin productos
            return response()->json([
                ['nombre' => '...']
            ]);
        }

        return response()->json($carpinterias); //en el caso que no esté vacío retorna un JSON con las carpinterías
    }

    /**
     * Lista los productos de la carpintería indicada
     */
    public function productos($carpinteria) //recibe una carpintería
    {
        //si la carpintería no existe retorna un array vacío
        $existe = Carpinteria::where('id', $carpinteria)->exists();
        if(!$existe) {
            return response()->json([]);
        }

        //recoge los productos de dicha carpintería seleccionando solo el id y el nombre
        $productos = Producto::where('carpinteria_id', $carpinteria)->select('id','nombre')->get();
        
        return response()->json($productos); //retorna el JSON de los productos
    }
}
