<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TrabajoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Trabajo::class);
        $trabajos = Trabajo::with('carpinteria')->get();
        return view('admin.trabajos.index', ['trabajos' => $trabajos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Trabajo::class);
        $carpinterias = Carpinteria::all();
        return view('admin.trabajos.create', ['carpinterias' => $carpinterias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Trabajo::class);
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id',
            'imagen' => 'required|image|mimes:png,jpg,jpeg,webp|dimensions:min_width=600,min_height=400'
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'imagen.required' => 'La imagen es obligatoria',
            'imagen.image' => 'Debe ser una imagen válida',
            'imagen.mimes' => 'El tipo de archivo no es correcto',
            'imagen.dimensions' => 'La imagen debe tener al menos 600x400 px',
        ]);

        //instancia creada del gestor de imagenes junto la carga base64 y redimensionar
        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(600, 400);

        //crear nombre para la imagen y defino la ruta
        $carpinteria = Carpinteria::findOrFail($request->carpinteria_id)->nombre;
        $nombreArchivo = 'trabajo_' . str_replace(' ', '_', strtoupper($carpinteria)) . time() . '.webp';
        $ruta = storage_path('app/public/trabajos/' . $nombreArchivo);

        //si no existe la carpeta la crea
        if (!file_exists(storage_path('app/public/trabajos'))) {
            mkdir(storage_path('app/public/trabajos'), 0755, true);
        }

        //la guarda en webp con la maxima calidad
        $imagen->toWebp(100)->save($ruta);

        //registro en la bbdd
        Trabajo::create([
            'carpinteria_id' => $request->carpinteria_id,
            'imagen' => 'trabajos/' . $nombreArchivo,
        ]);

        return redirect()->route('trabajos.index')->with('successTrabajoStore', 'Trabajo creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trabajo $trabajo)
    {
        $this->authorize('update', Trabajo::class);
        $carpinterias = Carpinteria::all();
        return view('admin.trabajos.edit', ['carpinterias' => $carpinterias, 'trabajo' => $trabajo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trabajo $trabajo)
    {
        $this->authorize('update', Trabajo::class);
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id',
            'imagen' => 'required'
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'imagen.required' => 'La imagen es obligatoria',
        ]);

        //elimina la imagen anterior si existe
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        //instancia creada del gestor de imagenes
        $manager = new ImageManager(new Driver());

        //lee la imagen base64 recibida y redimensionar a esos px
        $imagen = $manager->read($request->cropped_image)->resize(600, 400);

        //crea el nombre para la imagen y defino ruta
        $carpinteria = Carpinteria::findOrFail($request->carpinteria_id)->nombre;
        $nombreArchivo = 'trabajo_' . str_replace(' ', '_', strtoupper($carpinteria)) . time() . '.webp';
        $ruta = storage_path('app/public/trabajos/' . $nombreArchivo);

        //a webp con la maxima calidad
        $imagen->toWebp(100)->save($ruta);

        //actualizar el registro en la bbdd
        $trabajo->update([
            'carpinteria_id' => $request->carpinteria_id,
            'imagen' => 'trabajos/' . $nombreArchivo,
        ]);

        return redirect()->route('trabajos.index')->with('successTrabajoUpdate', 'Trabajo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trabajo $trabajo)
    {
        $this->authorize('delete', Trabajo::class);
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        $trabajo->delete();

        return redirect()->route('trabajos.index')->with('successTrabajoDelete', 'Trabajo eliminado correctamente');
    }
}
