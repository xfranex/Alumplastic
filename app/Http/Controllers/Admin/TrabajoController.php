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
     * Listando todos los trabajos
     */
    public function index()
    {
        $this->authorize('viewAny', Trabajo::class); //aplicando la policy
        $trabajos = Trabajo::with('carpinteria')->get(); //recoge todos los trabajos con la relación 'carpintería'
        return view('admin.trabajos.index', ['trabajos' => $trabajos]); //retorna la vista pasándole los trabajos
    }

    /**
     * Formulario de creación de un trabajo
     */
    public function create()
    {
        $this->authorize('create', Trabajo::class); //aplicando la policy
        $carpinterias = Carpinteria::all(); //recoge todas las carpinterías para datos de apoyo al crear el trabajo
        return view('admin.trabajos.create', ['carpinterias' => $carpinterias]); //retorna la vista pasándole las carpinterías ya que la fk de trabajos tiene que ser el id de la carpintería relacionada al trabajo creado
    }

    /**
     * Método para almacenar un trabajo
     */
    public function store(Request $request) //recibe parámetros
    {
        $this->authorize('create', Trabajo::class); //aplicando la policy
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id', //obligatorio y que exista el id en la tabla carpinterías
            'cropped_image' => 'required', //obligatorio y es base64 por eso necesito la librería php Intervention Image
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]); //mensajes personalizados por si salta el validate

        //instancia creada del gestor de imágenes junto la carga base64 y redimensionar
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

        //la guarda en webp con la máxima calidad
        $imagen->toWebp(100)->save($ruta);

        //registro en la bbdd
        Trabajo::create([
            'carpinteria_id' => $request->carpinteria_id,
            'imagen' => 'trabajos/' . $nombreArchivo,
        ]);

        return redirect()->route('trabajos.index')->with('successTrabajoStore', 'Trabajo creado correctamente'); //redirección a la ruta con mensaje flash
    }

    /**
     * Formulario de edición de un trabajo
     */
    public function edit(Trabajo $trabajo) //recibe el trabajo
    {
        $this->authorize('update', Trabajo::class); //aplicando la policy
        $ruta = storage_path('app/public/' . $trabajo->imagen); //obtiene la ruta física de la imagen asociada al trabajo en el almacenamiento
        $manager = new ImageManager(new Driver()); //crea una instancia del gestor de imágenes de Intervention Image usando el driver GD
        $imagen = $manager->read($ruta)->toWebp(); //lee la imagen desde la ruta y la convierte a WebP
        $imagenBase64 = 'data:image/webp;base64,' . base64_encode($imagen); //convierte la imagen a base64 para mostrar como preview en formulario
        $carpinterias = Carpinteria::all(); //obtiene todas las carpinterías para el select del formulario
        $carpinteria = $trabajo->carpinteria; //obtiene la carpinteria asociada al trabajo que se está editando
        //retorna la vista con los datos que necesita el formulario de edición tal como las carpinterías, trabajo seleccionado a editar, imagen en base64 del trabajo y carpintería actual de ese trabajo
        return view('admin.trabajos.edit', ['carpinterias' => $carpinterias, 'trabajo' => $trabajo, 'imagenBase64' => $imagenBase64, 'carpinteria' => $carpinteria]);
    }

    /**
     * Método para completar la edición de un trabajo
     */
    public function update(Request $request, Trabajo $trabajo) //recibe los parámetros y el trabajo a actualizar
    {
        $this->authorize('update', Trabajo::class); //aplicando la policy
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id', //obligatorio y que exista el id en la tabla carpinterías
            'cropped_image' => 'required', //obligatorio
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]); //mensajes personalizados

        //elimina la imagen anterior si existe
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        //instancia creada del gestor de imágenes
        $manager = new ImageManager(new Driver());

        //lee la imagen base64 recibida y redimensiona a esos px
        $imagen = $manager->read($request->cropped_image)->resize(600, 400);

        //crea el nombre para la imagen y defino ruta
        $carpinteria = Carpinteria::findOrFail($request->carpinteria_id)->nombre;
        $nombreArchivo = 'trabajo_' . str_replace(' ', '_', strtoupper($carpinteria)) . time() . '.webp';
        $ruta = storage_path('app/public/trabajos/' . $nombreArchivo);

        //a webp con la máxima calidad
        $imagen->toWebp(100)->save($ruta);

        //actualizar el registro en la bbdd
        $trabajo->update([
            'carpinteria_id' => $request->carpinteria_id,
            'imagen' => 'trabajos/' . $nombreArchivo,
        ]);

        return redirect()->route('trabajos.index')->with('successTrabajoUpdate', 'Trabajo actualizado correctamente'); //redirección a la ruta con mensaje flash
    }

    /**
     * Elimina un trabajo
     */
    public function destroy(Trabajo $trabajo) //recibimos el trabajo
    {
        $this->authorize('delete', Trabajo::class); //aplicando la policy
        //si existe la imagen en el almacenamiento local que es el disco public entonces elimina la imagen del trabajo asociado
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        $trabajo->delete(); //elimina el trabajo después de eliminar su imagen

        return redirect()->route('trabajos.index')->with('successTrabajoDelete', 'Trabajo eliminado correctamente'); //redirección a la ruta con mensaje flash
    }
}
