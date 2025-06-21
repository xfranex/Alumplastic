<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'nombre.unique'   => 'El nombre ya está registrado, por favor elige otro',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);

        Serie::create([
            'nombre' => strtoupper($request->nombre),
        ]);

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
            'nombre.unique'   => 'El nombre ya está registrado, por favor elige otro',
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
        $serie->delete();
        return redirect()->route('series.index')->with('successSerieDelete', 'Serie eliminada correctamente');
    }
}
