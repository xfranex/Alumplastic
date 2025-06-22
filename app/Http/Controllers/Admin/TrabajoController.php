<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trabajos = Trabajo::with('carpinteria')->get();
        return view('admin.trabajos.index', ['trabajos' => $trabajos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carpinterias = Carpinteria::all();
        return view('admin.trabajos.create', ['carpinterias' => $carpinterias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id',
            'cropped_image' => 'required|string',
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]);

        $croppedImage = $request->input('cropped_image');

        $manager = new ImageManager(new Driver());
        $image = $manager->read($croppedImage);

        $image = $image->resize(600, 400);

        $filename = 'trabajo_' . time() . '.webp';
        $path = storage_path('app/public/trabajos/' . $filename);

        if (!file_exists(storage_path('app/public/trabajos'))) {
            mkdir(storage_path('app/public/trabajos'), 0755, true);
        }

        $image->toWebp(100)->save($path);

        $trabajo = new Trabajo();
        $trabajo->carpinteria_id = $request->carpinteria_id;
        $trabajo->imagen = 'trabajos/' . $filename;
        $trabajo->save();

        return redirect()->route('trabajos.index')->with('successTrabajoStore', 'Trabajo creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trabajo $trabajo)
    {
        $carpinterias = Carpinteria::all();
        return view('admin.trabajos.edit', ['carpinterias' => $carpinterias, 'trabajo' => $trabajo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trabajo $trabajo)
    {
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id',
            'cropped_image' => 'required|string',
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]);

        $croppedImage = $request->input('cropped_image');

        if (preg_match('/^data:image\/(\w+);base64,/', $croppedImage, $type)) {
            $croppedImage = substr($croppedImage, strpos($croppedImage, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                return back()->withErrors(['cropped_image' => 'Formato de imagen no soportado']);
            }

            $croppedImage = base64_decode($croppedImage);
            if ($croppedImage === false) {
                return back()->withErrors(['cropped_image' => 'Imagen inválida']);
            }
        } else {
            return back()->withErrors(['cropped_image' => 'Imagen inválida']);
        }

        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($croppedImage);

        $image->resize(600, 400);

        $filename = 'trabajo_' . time() . '.webp';
        $path = storage_path('app/public/trabajos/' . $filename);

        if (!file_exists(storage_path('app/public/trabajos'))) {
            mkdir(storage_path('app/public/trabajos'), 0755, true);
        }

        $image->toWebp(100)->save($path);

        $trabajo->carpinteria_id = $request->carpinteria_id;
        $trabajo->imagen = 'trabajos/' . $filename;
        $trabajo->save();

        return redirect()->route('trabajos.index')->with('successTrabajoUpdate', 'Trabajo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trabajo $trabajo)
    {
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        $trabajo->delete();

        return redirect()->route('trabajos.index')->with('successTrabajoDelete', 'Trabajo eliminado correctamente');
    }
}
