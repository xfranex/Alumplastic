<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    use AuthorizesRequests;
    /**
     * Lista todas las series y limpia las variables de sesión que son utilizadas en las vistas, importante este bloque
     */
    public function index()
    {
        $this->authorize('viewAny', Serie::class); //aplicando la policy
        //todo esto repito los bloques en diferentes partes porque si no se completa la creación de la serie o le da a cancelar los datos se seguirán poniendo en cualquier formulario y no los datos que tendrían que ser por tanto es una forma de asegurar, fallo detectado en mi fase debug y es mi forma de subsanar
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }

        $series = Serie::all(); //recoge todas las series de la bbdd
        return view('admin.series.index', ['series' => $series]); //retorna la vista y le pasa las series 
    }

    /**
     * Formulario de creación de serie
     */
    public function create()
    {
        $this->authorize('create', Serie::class); //aplicando la policy
        return view('admin.series.create'); //retorna la vista
    }

    /**
     * Método para almacenar una serie
     */
    public function store(Request $request) //recibe parámetros
    {
        $this->authorize('create', Serie::class); //aplicando la policy
        $request->validate([
            'nombre' => 'required|string|unique:series,nombre|max:255', //obligatorio, cadena de texto, que no se repita el nombre en la tabla series, máximo 255 caracteres
        ],[
            'nombre.required' => 'El nombre de la serie es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]); //mensajes personalizados para el validate

        Serie::create([
            'nombre' => strtoupper($request->nombre), //almacena la serie en mayúsculas
        ]);

        //si se cumpla la condición de que tiene todas estas sesiones entonces se almacenan en una variable y se olvida la sesión para luego hacer una redirección al método
        //edit de ProductoSerieController pasándole los dos id y guarda en una sesión flash temporalmente formProducto para que se coloque en los campos y esto hace que no tenga que volver a escribir todo de nuevo cuando vuelva al formulario
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            $formProducto = session('formProducto');
            $productoId = session('producto');
            $serieId = session('serie');

            session()->forget(['formProducto', 'producto', 'serie']);

            return redirect()->route('productos.series.edit', ['producto' => $productoId, 'serie' => $serieId])->with('formProducto', $formProducto);
        }

        //si se cumple la condición que tiene estas dos sesiones entonces lo almacena en una variable y se olvida la sesión para hacer una redirección a la ruta para que nos lleve
        //al formulario de creación de un producto dentro de una carpintería por ello le pasamos el id de la carpintería y una sesión flash formProducto para que coloque los datos que hemos rellenado para no tener que volver a escribirlos
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            $formProducto = session('formProducto');
            $carpinteriaId = session('carpinteria');

            session()->forget(['formProducto', 'carpinteria']);

            return redirect()->route('carpinterias.productos.create', $carpinteriaId)->with('formProducto', $formProducto);
        }

        //si se cumple la condición que tiene estas dos sesiones entonces lo almacena en una variable y se olvida la sesión para hacer una redirección a la ruta para que nos lleve
        //al formulario de creación de una serie en un producto para ello le pasamos el id del producto y una sesión flash formProducto con lo que el usuario ya había rellenado
        if (session()->has('formProducto') && session()->has('producto')) {
            $formProducto = session('formProducto');
            $productoId = session('producto');

            session()->forget(['formProducto', 'producto']);

            return redirect()->route('productos.series.create', $productoId)->with('formProducto', $formProducto);
        }
        //todo estos casos son dependiendo de que en que formulario se encuentre sepa tratar luego de crear una serie para volver de nuevo al formulario luego de haberle dado a crear serie ya que no existe y esto hace que los datos escritos se MANTENGAN

        //si no entra en ningún if ya que estamos creando una serie simplemente entonces redirecciona a la ruta index de series para volver a listar todas las series ejecutando ese método y con un mensaje flash de sesión
        return redirect()->route('series.index')->with('successSerieStore', 'Serie creada correctamente');
    }

    /**
     * Formulario de edición de una serie
     */
    public function edit(Serie $serie) //recibimos la serie
    {
        $this->authorize('update', Serie::class); //aplicamos la policy
        return view('admin.series.edit', ['serie' => $serie]); //retornamos la vista pasándole la serie
    }

    /**
     * Método para actualizar una serie
     */
    public function update(Request $request, Serie $serie) //recibimos el parámetro y la serie a actualizar
    {
        $this->authorize('update', Serie::class);
        $request->validate([
            'nombre' => 'required|string|max:255|unique:series,nombre,' . $serie->id, //obligatorio, cadena de texto, máximo 255 caracteres y que el nombre sea único en la tabla series excepto el suyo mismo si no, no nos dejaría actualizarlo
        ], [
            'nombre.required' => 'El nombre de la serie es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]);//mensajes personalizados 

        $serie->nombre = strtoupper($request->nombre); //almacena en mayúsculas el nombre de la serie
        $serie->save(); //guarda la serie
        return redirect()->route('series.index')->with('successSerieUpdate', 'Serie actualizada correctamente'); //redirección de la ruta con mensaje flash
    }

    /**
     * Elimina una serie y lo que conlleva esta eliminación
     */
    public function destroy(Serie $serie) //recibe una serie
    {
        $this->authorize('delete', Serie::class); //aplicando la policy
        $productos = $serie->productos; //saca los productos asociados a esa serie

        foreach ($productos as $producto) { //por cada producto....
            $imagen = $producto->series()->where('serie_id', $serie->id)->first()->pivot->imagen; //obtiene la ruta de la imagen almacenada en la tabla pivot

            $producto->series()->detach($serie->id); //elimina la relación entre el producto y la serie en la tabla pivot ya que esta serie fue eliminada por tanto los productos que tengan esta serie se tiene que desasociar esta serie

            if ($imagen && Storage::disk('public')->exists($imagen)) {//si  existe la imagen en storage se elimina la imagen para que no se quede huérfana
                Storage::disk('public')->delete($imagen);
            }

            if ($producto->series()->count() == 0) { //si ya no le quedan series al producto lo tenemos que eliminar porque tiene que existir un producto con al menos una serie sí o sí dentro de una carpintería
                if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $producto->delete();
            }
        }

        $serie->delete();//finalmente elimina la serie

        return redirect()->route('series.index')->with('successSerieDelete', 'Serie eliminada correctamente'); //redirecciona a la ruta con un mensaje flash
    }
}
