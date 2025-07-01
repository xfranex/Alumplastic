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
        $productos = $carpinteria->productos()->with('series')->get();
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
        $request->validate([
            'nombre' => 'required|max:255|unique:productos,nombre,NULL,id,carpinteria_id,' . $carpinteria->id,
            'serie_id' => 'required|exists:series,id',
            'descripcion' => 'required',
            'imagen' => 'required',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'descripcion.required' => 'La descripción es obligatoria',
            'imagen.required' => 'La imagen es obligatoria',
        ]);

        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->imagen)->resize(600, 400);

        $nombreArchivo = 'producto_' . str_replace(' ', '_', $request->nombre) . '_' . $carpinteria->nombre . time() . '.webp';
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
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->load('carpinteria', 'series');
        return view('admin.productos.show', ['producto' => $producto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $producto->load('carpinteria', 'series'); 
        $series = Serie::all();
        return view('admin.productos.edit', ['producto' => $producto, 'series' => $series]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:productos,nombre,' . $producto->id . ',id,carpinteria_id,' . $producto->carpinteria_id,
            'serie_id' => 'required|exists:series,id',
            'descripcion' => 'required',
            'imagen' => 'required',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'descripcion.required' => 'La descripción es obligatoria',
            'imagen.required' => 'La imagen es obligatoria',
        ]);

        $datosPivot = $producto->series()->where('series.id', $request->serie_id)->first();

        if ($datosPivot && $datosPivot->pivot->imagen && Storage::disk('public')->exists($datosPivot->pivot->imagen)) {
            Storage::disk('public')->delete($datosPivot->pivot->imagen);
        }

        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->imagenn)->resize(600, 400);

        $nombreArchivo = 'producto_' . str_replace(' ', '_', $request->nombre) . '_' . $producto->carpinteria->nombre . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);
        $imagen->toWebp(100)->save($ruta);

        $producto->nombre = strtoupper($request->nombre);
        $producto->save();

        $producto->series()->detach($request->serie_id);
        $producto->series()->attach($request->serie_id, [
            'descripcion' => $request->descripcion,
            'imagen' => 'productos/' . $nombreArchivo,
        ]);

        return redirect()->route('carpinterias.productos.index', $producto->carpinteria)->with('successProductoUpdate', 'Producto actualizado correctamente');
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
