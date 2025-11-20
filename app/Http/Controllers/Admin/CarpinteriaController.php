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
     * Lista todas las carpinterías y limpia las variables de sesión que son utilizadas en las vistas
     */
    public function index() //no recibe parámetros
    {
        $this->authorize('viewAny', Carpinteria::class);//policy aplicada
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }
        
        $carpinterias = Carpinteria::all(); //recoge todas las carpinterias
        return view('admin.carpinterias.index', ['carpinterias' => $carpinterias]); //retorna la vista y le pasa la variable
    }

    /**
     * Formulario de creación de carpintería
     */
    public function create()
    {
        $this->authorize('create', Carpinteria::class); //aplicando la policy
        return view('admin.carpinterias.create'); //retorna la vista
    }

    /**
     * Método para almacenar la carpintería
     */
    public function store(Request $request)
    {
        $this->authorize('create', Carpinteria::class); //aplicando la policy
        $request->validate([
            'nombre' => 'required|string|unique:carpinterias,nombre|max:255', //validando que este relleno sea un string no se repita la misma carpintería y longitud de 255 como máximo
        ],[
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]); //mensajes para la vista en caso de que salte el validate

        Carpinteria::create([
            'nombre' => strtoupper($request->nombre), //creación de la carpintería en mayúscula
        ]);

        return redirect()->route('carpinterias.index')->with('successCarpinteriaStore', 'Carpintería creada correctamente'); //redirección a la ruta con un mensaje flash que está en la sesión
    }

    /**
     *  Formulario de edición de una carpinteria
     */
    public function edit(Carpinteria $carpinteria) //recibimos una carpintería
    {
        $this->authorize('update', Carpinteria::class); //aplicando la policy
        return view('admin.carpinterias.edit', ['carpinteria' => $carpinteria]); //retorna la vista de edición con la carpintería seleccionada
    }

    /**
     * Método para completar la edición de la carpintería
     */
    public function update(Request $request, Carpinteria $carpinteria) //inyección de dependencias request y recibe la carpinteria
    {
        $this->authorize('update', Carpinteria::class); //aplicando la policy
        $request->validate([
            'nombre' => 'required|string|max:255|unique:carpinterias,nombre,' . $carpinteria->id, //el nombre sea obligatorio una cadena de texto no supere los 255 caracteres y valida que el nombre sea único en la tabla carpinterías excepto para la carpintería que se está editando
        ], [
            'nombre.required' => 'El nombre de la carpintería es obligatorio',
            'nombre.string'   => 'El nombre debe ser una cadena de texto',
            'nombre.unique'   => 'El nombre ya está registrado',
            'nombre.max'      => 'El nombre no debe superar los 255 caracteres',
        ]); //mensajes que saltan en la vista

        $carpinteria->nombre = strtoupper($request->nombre); //actualiza el nombre de la carpinteria y lo coloca en mayúsculas el pasado
        $carpinteria->save(); //lo guarda en bbdd
        return redirect()->route('carpinterias.index')->with('successCarpinteriaUpdate', 'Carpintería actualizada correctamente'); //redirección a la ruta con mensaje flash
    }

    /**
     * Elimina la carpintería pasada y todo lo que conlleva esa eliminación como que borra todos sus productos series y trabajos asociados junto con sus imagenes para no dejar cosas huérfanas
     */
    public function destroy(Carpinteria $carpinteria)
    {
        $this->authorize('delete', Carpinteria::class); //aplicando la policy
        foreach ($carpinteria->productos as $producto) { //todos los productos de la carpinteria
            foreach ($producto->series as $serie) { //todas las series de dicho producto
                if ($serie->pivot && $serie->pivot->imagen) { //comprueba que exista el registro pivot de esa tabla 
                    if (Storage::disk('public')->exists($serie->pivot->imagen)) { //comprueba que exista el archivo en el disco public 
                        Storage::disk('public')->delete($serie->pivot->imagen); //si existe entonces elimina la imagen del disco public optimizando los recursos del servidor y no quedándose imagenes huérfanas
                    }
                }
            }
            $producto->series()->detach(); //desvincula todas las relaciones many-to-many entre el producto y sus series  las filas pivot fuera
            $producto->delete(); //finalmente elimina el producto de la bbdd
        }

        foreach ($carpinteria->trabajos as $trabajo) { //todos los trabajos de la carpintería van a ser iterados
            if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) { //comprueba que exista el archivo en el disco public
                Storage::disk('public')->delete($trabajo->imagen); //si se cumple entonces elimina la imagen del disco public y se limpia los trabajos relacionados con esa carpinteria
            }
            $trabajo->delete(); //finalmente elimina el trabajo y vuelve a dar otra vuelta haciendo lo mismo con el siguiente registro
        }
        $carpinteria->delete(); //por último elimina la carpintería que es lo que le queda
        return redirect()->route('carpinterias.index')->with('successCarpinteriaDelete', 'Carpintería eliminada correctamente'); //redirección a la ruta con un mensaje flash
    }
}
