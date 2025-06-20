<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use Illuminate\Http\Request;

class CarpinteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carpinterias = Carpinteria::all();
        return view('admin.carpinterias.index', ['carpinterias' => $carpinterias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carpinterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:carpinterias,nombre|max:255',
        ],[
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado, por favor elige otro',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);

        Carpinteria::create([
            'nombre' => strtoupper($request->nombre),
        ]);

        return redirect()->route('carpinterias.index')->with('successCarpinteriaStore', 'Carpintería creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carpinteria $carpinteria)
    {
        return view('admin.carpinterias.edit', ['carpinteria' => $carpinteria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carpinteria $carpinteria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:carpinterias,nombre,' . $carpinteria->id,
        ], [
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado, por favor elige otro',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);

        $carpinteria->nombre = strtoupper($request->nombre);
        $carpinteria->save();
        return redirect()->route('carpinterias.index')->with('successCarpinteriaUpdate', 'Carpintería actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carpinteria $carpinteria)
    {
        $carpinteria->delete();
        return redirect()->route('carpinterias.index')->with('successCarpinteriaDelete', 'Carpintería eliminada correctamente');
    }
}
