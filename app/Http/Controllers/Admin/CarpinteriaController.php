<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarpinteriaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Carpinteria::class);
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        
        $carpinterias = Carpinteria::all();
        return view('admin.carpinterias.index', ['carpinterias' => $carpinterias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Carpinteria::class);
        return view('admin.carpinterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Carpinteria::class);
        $request->validate([
            'nombre' => 'required|string|unique:carpinterias,nombre|max:255',
        ],[
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
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
        $this->authorize('update', Carpinteria::class);
        return view('admin.carpinterias.edit', ['carpinteria' => $carpinteria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carpinteria $carpinteria)
    {
        $this->authorize('update', Carpinteria::class);
        $request->validate([
            'nombre' => 'required|string|max:255|unique:carpinterias,nombre,' . $carpinteria->id,
        ], [
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
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
        $this->authorize('delete', Carpinteria::class);
        foreach ($carpinteria->productos as $producto) {
            foreach ($producto->series as $serie) {
                if ($serie->pivot && $serie->pivot->imagen) {
                    if (Storage::disk('public')->exists($serie->pivot->imagen)) {
                        Storage::disk('public')->delete($serie->pivot->imagen);
                    }
                }
            }
            $producto->series()->detach();
            $producto->delete();
        }

        foreach ($carpinteria->trabajos as $trabajo) {
            if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
                Storage::disk('public')->delete($trabajo->imagen);
            }
            $trabajo->delete();
        }
        $carpinteria->delete();
        return redirect()->route('carpinterias.index')->with('successCarpinteriaDelete', 'Carpintería eliminada correctamente');
    }
}
