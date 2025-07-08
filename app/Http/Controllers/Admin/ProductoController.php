<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Producto;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Carpinteria $carpinteria)
    {
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        
        $productos = $carpinteria->productos;
        return view('admin.productos.index', ['productos' => $productos, 'carpinteria' => $carpinteria]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Carpinteria $carpinteria)
    {
        $series = Serie::all();
        return view('admin.productos.create', ['carpinteria' => $carpinteria, 'series' => $series]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Carpinteria $carpinteria)
    {
        if ($request->accion === 'crear_serie') {
            session([
                'formProducto' => [
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                ],
                'carpinteria' => $carpinteria->id,
            ]);

            return redirect()->route('series.create');
        }
        
        $request->validate([
            'nombre' => 'required|max:255|unique:productos,nombre,NULL,id,carpinteria_id,' . $carpinteria->id,
            'serie_id' => 'required|exists:series,id',
            'descripcion' => 'required',
            'imagen' => 'required|image|mimes:png,jpg,jpeg,webp',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'descripcion.required' => 'La descripción es obligatoria',
            'imagen.required' => 'La imagen es obligatoria',
            'imagen.image' => 'Debe ser una imagen válida',
            'imagen.mimes' => 'El tipo de archivo no es correcto',
        ]);
        
        $nombreSerie = Serie::findorFail($request->serie_id);

        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        $nombreArchivo = 'producto_' . str_replace(' ', '_', $nombreSerie->nombre) . '_' . str_replace(' ', '_', $request->nombre) . '_' . $carpinteria->nombre . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true);
        }

        $imagen->toWebp(100)->save($ruta);

        $producto = $carpinteria->productos()->create([
            'nombre' => strtoupper($request->nombre),
        ]);

        $producto->series()->attach($request->serie_id, [
            'descripcion' => $request->descripcion,
            'imagen' => 'productos/' . $nombreArchivo,
        ]);

        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoStore', 'Producto creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $carpinteria = $producto->carpinteria;
        return view('admin.productos.edit', ['producto' => $producto, 'carpinteria' => $carpinteria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $carpinteria = $producto->carpinteria;
        $request->validate([
            'nombre' => 'required|max:255|unique:productos,nombre,' . $producto->id . ',id,carpinteria_id,' . $producto->carpinteria_id,
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
        ]);

        $producto->nombre =  strtoupper($request->nombre);
        $producto->save();

        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoUpdate', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $carpinteria = $producto->carpinteria;
        foreach ($producto->series as $serie) {
            if ($serie->pivot->imagen && Storage::disk('public')->exists($serie->pivot->imagen)) {
                Storage::disk('public')->delete($serie->pivot->imagen);
            }
        }

        $producto->series()->detach();
        $producto->delete();
        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoDelete', 'Producto eliminado correctamente');
    }
}
