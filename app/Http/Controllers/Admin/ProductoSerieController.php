<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Serie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductoSerieController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Producto $producto)
    {
        $this->authorize('viewAny', Producto::class);
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }

        $carpinteria = $producto->carpinteria;
        $series = $producto->series()->withPivot('descripcion', 'imagen')->get();
        return view('admin.productos.series.index', ['producto' => $producto, 'series' => $series, 'carpinteria' => $carpinteria]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Producto $producto)
    {
        $this->authorize('create', Producto::class);
        $series = Serie::all();
        return view('admin.productos.series.create', ['producto' => $producto, 'series' => $series]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Producto $producto)
    {
        $this->authorize('create', Producto::class);
        if ($request->accion === 'crear_serie') {
            session([
                'formProducto' => [
                    'descripcion' => $request->descripcion,
                    'cropped_image' => $request->cropped_image,
                ],
                'producto' => $producto->id,
            ]);

            return redirect()->route('series.create');
        }

        $request->validate([
            'serie_id' => 'required|exists:series,id|unique:producto_serie,serie_id,NULL,id,producto_id,' . $producto->id,
            'descripcion' => 'required',
            'cropped_image' => 'required',
        ], [
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'serie_id.unique' => 'La serie ya está asociada',
            'descripcion.required' => 'La descripción es obligatoria',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]);
        
        $nombreSerie = Serie::findorFail($request->serie_id);
        $carpinteria = $producto->carpinteria;

        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        $nombreArchivo = 'producto_' . str_replace(' ', '_', strtoupper($nombreSerie->nombre)) . '_' . str_replace(' ', '_', strtoupper($producto->nombre)) . '_' . str_replace(' ', '_', strtoupper($carpinteria->nombre)) . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true);
        }

        $imagen->toWebp(100)->save($ruta);

        $producto->series()->attach($request->serie_id, [
            'descripcion' => $request->descripcion,
            'imagen' => 'productos/' . $nombreArchivo,
        ]);

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoStore', 'Asociación creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto, Serie $serie)
    {
        $this->authorize('view', Producto::class);
        $serieRelacionada = $producto->series()->where('series.id', $serie->id)->first();
        $carpinteria = $producto->carpinteria;
        return view('admin.productos.series.show', ['carpinteria' => $carpinteria, 'producto' => $producto, 'serie' => $serieRelacionada]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto, Serie $serie)
    {
        $this->authorize('update', Producto::class);
        $series = Serie::all();
        $carpinteria = $producto->carpinteria;
        $pivotAct = $producto->series()->where('series.id', $serie->id)->first()->pivot;
        $ruta = storage_path('app/public/' . $pivotAct->imagen);
        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($ruta)->toWebp();
        $imagenBase64 = 'data:image/webp;base64,' . base64_encode($imagen);
        return view('admin.productos.series.edit', ['producto' => $producto, 'serie' => $serie, 'seriesT' => $series, 'pivotAct' => $pivotAct, 'carpinteria' => $carpinteria, 'imagenBase64' => $imagenBase64]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto, Serie $serie)
    {
        $this->authorize('update', Producto::class);
        if ($request->accion === 'crear_serie') {
            session([
                'formProducto' => [
                    'descripcion' => $request->descripcion,
                    'cropped_image' => $request->cropped_image,
                ],
                'producto' => $producto->id,
                'serie' => $serie->id,
            ]);

            return redirect()->route('series.create');
        }

        $request->validate([
            'serie_id' => 'required|exists:series,id|unique:producto_serie,serie_id,' . $serie->id . ',serie_id,producto_id,' . $producto->id,
            'descripcion' => 'required',
            'cropped_image' => 'required',
        ], [
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'serie_id.unique' => 'La serie ya está asociada',
            'descripcion.required' => 'La descripción es obligatoria',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]);

        $pivotActual = $producto->series()->where('series.id', $serie->id)->first();
        if ($pivotActual && $pivotActual->pivot->imagen && Storage::disk('public')->exists($pivotActual->pivot->imagen)) {
            Storage::disk('public')->delete($pivotActual->pivot->imagen);
        }

        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        $nombreSerie = Serie::findorFail($request->serie_id);
        $carpinteria = $producto->carpinteria;
        $nombreArchivo = 'producto_' . str_replace(' ', '_', strtoupper($nombreSerie->nombre)) . '_' . str_replace(' ', '_', strtoupper($producto->nombre)) . '_' . str_replace(' ', '_', strtoupper($carpinteria->nombre)) . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true);
        }

        $imagen->toWebp(100)->save($ruta);

        if ($serie->id != $request->serie_id) {
            $producto->series()->detach($serie->id);
            $producto->series()->attach($request->serie_id, [
                'descripcion' => $request->descripcion,
                'imagen' => 'productos/' . $nombreArchivo,
            ]);
        } else {
            $producto->series()->updateExistingPivot($serie->id, [
                'descripcion' => $request->descripcion,
                'imagen' => 'productos/' . $nombreArchivo,
            ]);
        }

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoUpdate', 'Asociación editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto, Serie $serie)
    {
        $this->authorize('delete', Producto::class);
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
