<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Lista las series del producto pasado
     */
    public function series($producto) //recibe un producto
    {
        //si no encuentra el producto entonces devuelve un array vacío
        $producto = Producto::find($producto);
        if(!$producto) {
            return response()->json([]);
        }

        //obtiene todas las series relacionadas con el producto seleccionando solo los campos id y nombre de la tabla series y ocultando el pivot que aparece
        $series = $producto->series()->select('series.id', 'series.nombre')->get()->makeHidden('pivot');  
        
        return response()->json($series); //retorna el JSON de las series de dicho producto
    }

    /**
     * Visualiza en concreto la serie de un producto
     */
    public function virsualizar($producto, $serie) //recibe el producto y la serie
    {
        //si no encuentra el producto devuelve un array vacío
        $producto = Producto::find($producto);
        if (!$producto) {
            return response()->json([]);
        }

        //busca las series relacionadas con el producto y si no encuentra ninguna serie con el id pasado entonces devuelve un array vacío
        $serie = $producto->series()->where('serie_id', $serie)->first();
        if (!$serie) {
            return response()->json([]);
        }
        
        //retorna un JSON con el id del producto el de la serie con la descripción y la imagen
        return response()->json([
            'producto_id' => $serie->pivot->producto_id,
            'serie_id' => $serie->pivot->serie_id,
            'descripcion' => $serie->pivot->descripcion,
            'imagen' => $serie->pivot->imagen,
        ]);
    }
}
