<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Producto;
use App\Models\Serie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Lista los productos de una carpintería
     */
    public function index(Carpinteria $carpinteria) //recibe una carpintería
    {
        $this->authorize('viewAny', Producto::class); //aplicando la policy
        //todo esto repito los bloques en diferentes partes porque si no se completa la creación de la serie o le da a cancelar los datos se seguiran poniendo en cualquier formulario y no los datos que tendrian que ser por tanto es una forma de asegurar, fallo detectado en mi fase debug y es mi forma de subsanar
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }
        
        $productos = $carpinteria->productos; //saca los productos relacionados con esa carpintería gracias a Eloquent que es el ORM
        return view('admin.productos.index', ['productos' => $productos, 'carpinteria' => $carpinteria]); //retorna la vista pasándole la carpintería y sus productos
    }

    /**
     * Formulario de creación de un producto dentro de una carpintería
     */
    public function create(Carpinteria $carpinteria) //recibe la carpintería para saber donde meter el producto
    {
        $this->authorize('create', Producto::class); //aplicando la policy
        $series = Serie::all(); //coge todas las series
        return view('admin.productos.create', ['carpinteria' => $carpinteria, 'series' => $series]); //retorna la vista y le pasa la carpintería y las series para que la arme
    }

    /**
     * Método para guardar un producto en una carpintería
     */
    public function store(Request $request, Carpinteria $carpinteria) //recibimos parámetros y una carpintería
    {
        $this->authorize('create', Producto::class); //aplicando la policy
        //si en el campo oculto contiene 'crear_serie' esto es debido a que si pulsamos en el botón 'no existe la serie creala' esto ejecuta una función JavaScript que cambia rápidamente el valor de ese campo
        //y cuando lo envia el form llega a este método en el cual detecta ese campo que tiene el valor 'crear_serie' por lo tanto hace una sesión con los campos que hemos rellenado y la carpintería para poder volver de nuevo
        //y por último redirecciona a la ruta para crear una serie y ya le pasamos el testigo
        if ($request->accion === 'crear_serie') {
            session([
                'formProducto' => [
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'cropped_image' => $request->cropped_image,
                ],
                'carpinteria' => $carpinteria->id,
            ]);

            return redirect()->route('series.create');
        }

        //si el campo oculto no tiene valor seguimos por aquí
        $request->validate([
            'nombre' => 'required|max:255|unique:productos,nombre,NULL,id,carpinteria_id,' . $carpinteria->id, //obligatorio, máximo 255 caracteres y debe ser único dentro de los productos de esta misma carpintería
            'serie_id' => 'required|exists:series,id', //obligatorio, tiene que ser una serie que exista en la tabla series
            'descripcion' => 'required', //obligatoria
            'cropped_image' => 'required', //obligatoria
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'descripcion.required' => 'La descripción es obligatoria',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]);//mensajes personalizados
        
        $nombreSerie = Serie::findorFail($request->serie_id); //Busca la serie por id si no existe entonces 404

        //instancia creada del gestor de imagenes, lee la imagen base64 recibida y redimensionar a esos px
        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        //crea el nombre para la imagen y defino ruta
        $nombreArchivo = 'producto_' . str_replace(' ', '_', strtoupper($nombreSerie->nombre)) . '_' . str_replace(' ', '_', strtoupper($request->nombre)) . '_' . str_replace(' ', '_', strtoupper($carpinteria->nombre)) . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        //si no existe la carpeta la crea
        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true);
        }

        //la guarda en webp con la máxima calidad
        $imagen->toWebp(100)->save($ruta);

        //crea un producto ligada a esa carpintería
        $producto = $carpinteria->productos()->create([
            'nombre' => strtoupper($request->nombre),
        ]);

        //crea la relación en la tabla pivot con su descripción y su imagen en concreto
        $producto->series()->attach($request->serie_id, [
            'descripcion' => $request->descripcion,
            'imagen' => 'productos/' . $nombreArchivo,
        ]);

        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoStore', 'Producto creado correctamente'); //redirección a la ruta con mensaje flash
    }

    /**
     * Formulario de edición de un producto
     */
    public function edit(Producto $producto) //recibimos el producto
    {
        $this->authorize('update', Producto::class); //aplicando la policy
        $carpinteria = $producto->carpinteria; //sacamos la carpintería del producto
        $carpinterias = Carpinteria::all(); //recogemos todas las carpinterías
        return view('admin.productos.edit', ['producto' => $producto, 'carpinteria' => $carpinteria, 'carpinterias' => $carpinterias]); //retornamos la vista pasándole el producto, la carpintería de dicho producto y todas las carpinterías
    }

    /**
     * Método para actualizar un producto
     */
    public function update(Request $request, Producto $producto) //recibimos los parámetros y el producto a actualizar
    {
        $this->authorize('update', Producto::class); //aplicando la policy
        $carpinteria = $producto->carpinteria; //sacamos la carpintería de dicho producto
        $request->validate([
            'carpinteria_id' => 'required|exists:carpinterias,id', //obligatorio, exista la carpintería en la tabla carpinterías
            'nombre' => 'required|max:255|unique:productos,nombre,' . $producto->id . ',id,carpinteria_id,' . $producto->carpinteria_id, //obligatorio, máximo 255 caracteres y que debe ser único solo dentro de la misma carpintería pero ignorando el producto que se está editando
        ], [
            'carpinteria_id.required' => 'La carpintería es obligatoria',
            'carpinteria_id.exists' => 'La carpintería seleccionada no es válida',
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre es demasiado largo',
            'nombre.unique' => 'El nombre del producto ya existe en esta carpintería',
        ]); //mensajes personalizados

        $producto->carpinteria_id = $request->carpinteria_id; //actualizamos la carpintería del producto
        $producto->nombre =  strtoupper($request->nombre); //actualizamos el nombre colocándolo en mayúsculas
        $producto->save(); //guardamos el producto

        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoUpdate', 'Producto actualizado correctamente'); //redirección a la ruta pasándole la carpintería para que liste todos los productos de esa carpintería junto con un mensaje flash
    }

    /**
     * Eliminación de un producto
     */
    public function destroy(Producto $producto) //recibimos un producto
    {
        $this->authorize('delete', Producto::class); //aplicando la policy
        $carpinteria = $producto->carpinteria; //obtiene la carpintería que tiene el producto recibido
        foreach ($producto->series as $serie) { //recorre todas las series asociadas al producto
            if ($serie->pivot->imagen && Storage::disk('public')->exists($serie->pivot->imagen)) { //si tiene una imagen en el pivot....
                Storage::disk('public')->delete($serie->pivot->imagen); //elimina la imagen de la serie
            }
        }

        $producto->series()->detach(); //quitamos todas las series many-to-many
        $producto->delete(); //eliminamos finalmente el producto
        return redirect()->route('carpinterias.productos.index', $carpinteria)->with('successProductoDelete', 'Producto eliminado correctamente'); //redirección a la ruta pasándole la carpintería para que liste los productos de dicha carpintería junto con su mensaje flash
    }
}
