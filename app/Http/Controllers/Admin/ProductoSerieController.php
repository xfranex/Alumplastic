<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Serie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductoSerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Producto $producto)
    {
        $carpinteria = $producto->carpinteria;
        $series = $producto->series()->withPivot('descripcion', 'imagen')->get();
        return view('admin.productos.series.index', ['producto' => $producto, 'series' => $series, 'carpinteria' => $carpinteria]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto, Serie $serie)
    {
        $datosPivot = $producto->series()->where('series.id', $serie->id)->first()->pivot;
        if ($datosPivot->imagen && Storage::disk('public')->exists($datosPivot->imagen)) {
            Storage::disk('public')->delete($datosPivot->imagen);
        }

        $producto->series()->detach($serie->id); 

        if ($producto->series()->count() === 0) {
            $carpinteria = $producto->carpinteria;
            $producto->delete();

            return redirect()->route('carpinterias.productos.index', $carpinteria->id)->with('successSerieProductoDelete', 'Producto eliminado por falta de series asociadas');
        }

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoDelete', 'Serie eliminada correctamente');       
    }
}
