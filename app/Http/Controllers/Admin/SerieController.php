<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }

        $series = Serie::all();
        return view('admin.series.index', ['series' => $series]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.series.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:series,nombre|max:255',
        ],[
            'nombre.required' => 'El nombre de la serie es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);

        Serie::create([
            'nombre' => strtoupper($request->nombre),
        ]);

        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            $formProducto = session('formProducto');
            $productoId = session('producto');
            $serieId = session('serie');

            session()->forget(['formProducto', 'producto', 'serie']);

            return redirect()->route('productos.series.edit', ['producto' => $productoId, 'serie' => $serieId])->with('formProducto', $formProducto);
        }

        if (session()->has('formProducto') && session()->has('carpinteria')) {
            $formProducto = session('formProducto');
            $carpinteriaId = session('carpinteria');

            session()->forget(['formProducto', 'carpinteria']);

            return redirect()->route('carpinterias.productos.create', $carpinteriaId)->with('formProducto', $formProducto);
        }

        if (session()->has('formProducto') && session()->has('producto')) {
            $formProducto = session('formProducto');
            $productoId = session('producto');

            session()->forget(['formProducto', 'producto']);

            return redirect()->route('productos.series.create', $productoId)->with('formProducto', $formProducto);
        }

        return redirect()->route('series.index')->with('successSerieStore', 'Serie creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Serie $serie)
    {
        return view('admin.series.edit', ['serie' => $serie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Serie $serie)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:series,nombre,' . $serie->id,
        ], [
            'nombre.required' => 'El nombre de la serie es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);

        $serie->nombre = strtoupper($request->nombre);
        $serie->save();
        return redirect()->route('series.index')->with('successSerieUpdate', 'Serie actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Serie $serie)
    {
        $productos = $serie->productos;

        foreach ($productos as $producto) {
            $imagen = $producto->series()->where('serie_id', $serie->id)->first()->pivot->imagen;

            $producto->series()->detach($serie->id);

            if ($imagen && Storage::disk('public')->exists($imagen)) {
                Storage::disk('public')->delete($imagen);
            }

            if ($producto->series()->count() == 0) {
                if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $producto->delete();
            }
        }

        $serie->delete();

        return redirect()->route('series.index')->with('successSerieDelete', 'Serie eliminada correctamente');
    }
}
