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
     * Listamos las series de un producto
     */
    public function index(Producto $producto) //recibimos un producto
    {
        $this->authorize('viewAny', Producto::class); //aplicando la policy
        //todo esto repito los bloques en diferentes partes porque si no se completa la creación de la serie o le da a cancelar los datos se seguiran poniendo en cualquier formulario y no los datos que tendrian que ser por tanto es una forma de asegurar, fallo detectado en mi fase debug y es mi forma de subsanar
        if (session()->has('formProducto') && session()->has('producto') && session()->has('serie')) {
            session()->forget(['formProducto', 'producto', 'serie']);
        }
        if (session()->has('formProducto') && session()->has('producto')) {
            session()->forget(['formProducto', 'producto']);
        }
        if (session()->has('formProducto') && session()->has('carpinteria')) {
            session()->forget(['formProducto', 'carpinteria']);
        }

        $carpinteria = $producto->carpinteria; //sacamos la carpintería de dicho producto
        $series = $producto->series()->withPivot('descripcion', 'imagen')->get(); //sacamos todas las series relacionadas con el producto en la tabla pivot
        return view('admin.productos.series.index', ['producto' => $producto, 'series' => $series, 'carpinteria' => $carpinteria]); //retorna la vista pasándole el producto, sus series y la carpintería del producto
    }

    /**
     * Formulario de creación de una serie en un producto
     */
    public function create(Producto $producto) //recibimos un producto
    {
        $this->authorize('create', Producto::class); //aplicando la policy
        $series = Serie::all(); //recogemos todas las series
        $carpinteria = $producto->carpinteria; //sacamos la carpintería del producto pasado
        return view('admin.productos.series.create', ['producto' => $producto, 'series' => $series, 'carpinteria' => $carpinteria]); //retornamos la vista pasándole el producto, las series y la carpintería del producto
    }

    /**
     * Método para almacenar una serie dentro de un producto
     */
    public function store(Request $request, Producto $producto) //recibimos parámetros y un producto
    {
        $this->authorize('create', Producto::class); //aplicando la policy
        //si en el campo oculto contiene 'crear_serie' esto es debido a que si pulsamos en el botón 'no existe la serie creala' esto ejecuta una función JavaScript que cambia rápidamente el valor de ese campo
        //y cuando lo envia el form llega a este método en el cual detecta ese campo que tiene el valor 'crear_serie' por lo tanto hace una sesión con los campos que hemos rellenado y la carpintería para poder volver de nuevo
        //y por último redirecciona a la ruta para crear una serie y ya le pasamos el testigo
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

        //si el campo oculto no tiene valor seguimos por aquí
        $request->validate([
            'serie_id' => 'required|exists:series,id|unique:producto_serie,serie_id,NULL,id,producto_id,' . $producto->id, //obligatorio, exista en la tabla series y que no esté ya asociado al producto específico en la tabla pivote esto hace no halla dos series con el mismo nombre dentro de un producto
            'descripcion' => 'required', //obligatorio
            'cropped_image' => 'required', //obligatorio
        ], [
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'serie_id.unique' => 'La serie ya está asociada',
            'descripcion.required' => 'La descripción es obligatoria',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]); //mensajes personalizados
        
        //busca la serie por id si no encuentra da 404
        $nombreSerie = Serie::findorFail($request->serie_id);
        $carpinteria = $producto->carpinteria; //sacamos la carpintería del producto pasado

        //instancia creada del gestor de imagenes, lee la imagen base64 recibida y redimensionar a esos px
        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        //crea el nombre para la imagen y defino ruta
        $nombreArchivo = 'producto_' . str_replace(' ', '_', strtoupper($nombreSerie->nombre)) . '_' . str_replace(' ', '_', strtoupper($producto->nombre)) . '_' . str_replace(' ', '_', strtoupper($carpinteria->nombre)) . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        //si no existe la carpeta la crea
        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true);
        }

        //la guarda en webp con la maxima calidad
        $imagen->toWebp(100)->save($ruta);

        //crea una nueva serie en el producto y rellena la tabla pivote (producto_serie)
        $producto->series()->attach($request->serie_id, [
            'descripcion' => $request->descripcion,
            'imagen' => 'productos/' . $nombreArchivo,
        ]);

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoStore', 'Asociación creada correctamente'); //redirección a la ruta pasándole el producto para que liste sus series y un mensaje flash
    }

    /**
     * Visualiza la serie de un producto
     */
    public function show(Producto $producto, Serie $serie) //recibe un producto y una serie
    {
        $this->authorize('view', Producto::class); //aplicando la policy
        $serieRelacionada = $producto->series()->where('series.id', $serie->id)->first(); //busca la serie relacionada de ese producto
        $carpinteria = $producto->carpinteria; //obtiene la carpintería del producto
        return view('admin.productos.series.show', ['carpinteria' => $carpinteria, 'producto' => $producto, 'serie' => $serieRelacionada]); //retorna la vista pasándole la carpintería del producto, el producto y su serie
    }

    /**
     * Formulario de edición de una serie de un producto
     */
    public function edit(Producto $producto, Serie $serie) //recibimos un producto y una serie
    {
        $this->authorize('update', Producto::class); //aplicando la policy
        $series = Serie::all(); //recogemos todas las series
        $carpinteria = $producto->carpinteria; //sacamos la carpintería del producto
        $pivotAct = $producto->series()->where('series.id', $serie->id)->first()->pivot; //obtiene el registro de la tabla pivote correspondiente a este producto
        $ruta = storage_path('app/public/' . $pivotAct->imagen); //construyendo la ruta
        $manager = new ImageManager(new Driver()); //instancia creada del gestor de imagenes con el driver
        $imagen = $manager->read($ruta)->toWebp(); //lee el archivo de la imagen desde esa ruta y la convierte a webp
        $imagenBase64 = 'data:image/webp;base64,' . base64_encode($imagen); //conversión a cadena base64 para mostrarla en la vista el preview
        return view('admin.productos.series.edit', ['producto' => $producto, 'serie' => $serie, 'seriesT' => $series, 'pivotAct' => $pivotAct, 'carpinteria' => $carpinteria, 'imagenBase64' => $imagenBase64]); //retorna la vista pasándole el producto, la serie, todas las series, datos de pivote, la carpintería y la imagen codificada en base64 
    }

    /**
     * Método para actualizar la serie de un producto
     */
    public function update(Request $request, Producto $producto, Serie $serie) //recibe parámetros, un producto y una serie
    {
        $this->authorize('update', Producto::class); //aplicando la policy
        //si en el campo oculto contiene 'crear_serie' esto es debido a que si pulsamos en el botón 'no existe la serie creala' esto ejecuta una función JavaScript que cambia rápidamente el valor de ese campo
        //y cuando lo envia el form llega a este método en el cual detecta ese campo que tiene el valor 'crear_serie' por lo tanto hace una sesión con los campos que hemos rellenado y la carpintería para poder volver de nuevo
        //y por último redirecciona a la ruta para crear una serie y ya le pasamos el testigo
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

        //si el campo oculto está vacío sigue por aquí
        $request->validate([
            'serie_id' => 'required|exists:series,id|unique:producto_serie,serie_id,' . $serie->id . ',serie_id,producto_id,' . $producto->id, //obligatorio, debe de existir el id en la tabla series y que un mismo producto no tenga la misma serie duplicada en la tabla pivote
            'descripcion' => 'required', //obligatorio
            'cropped_image' => 'required', //obligatorio
        ], [
            'serie_id.required' => 'Debe seleccionar una serie',
            'serie_id.exists' => 'La serie seleccionada no es válida',
            'serie_id.unique' => 'La serie ya está asociada',
            'descripcion.required' => 'La descripción es obligatoria',
            'cropped_image.required' => 'La imagen es obligatoria',
        ]); //mensajes personalizados para el validate

        //verifica si el producto tiene la serie indicada y si existe una imagen en la relación pivote la elimina del almacenamiento
        $pivotActual = $producto->series()->where('series.id', $serie->id)->first();
        if ($pivotActual && $pivotActual->pivot->imagen && Storage::disk('public')->exists($pivotActual->pivot->imagen)) {
            Storage::disk('public')->delete($pivotActual->pivot->imagen);
        }

        //instancia creada del gestor de imagenes, lee la imagen base64 recibida y redimensionar a esos px
        $manager = new ImageManager(new Driver());
        $imagen = $manager->read($request->cropped_image)->resize(1600, 900);

        $nombreSerie = Serie::findorFail($request->serie_id); //obtiene la serie
        $carpinteria = $producto->carpinteria; //obtiene la carpintería del producto
        //con los datos anteriores buscados armamos el nombre para la imagen super completo y establecemos la ruta
        $nombreArchivo = 'producto_' . str_replace(' ', '_', strtoupper($nombreSerie->nombre)) . '_' . str_replace(' ', '_', strtoupper($producto->nombre)) . '_' . str_replace(' ', '_', strtoupper($carpinteria->nombre)) . time() . '.webp';
        $ruta = storage_path('app/public/productos/' . $nombreArchivo);

        //si no existe la carpeta la crea
        if (!file_exists(storage_path('app/public/productos'))) {
            mkdir(storage_path('app/public/productos'), 0755, true); //permite crear directorios anidados con los permisos correspondientes en la ruta escrita
        }

        //la guarda en webp con la maxima calidad
        $imagen->toWebp(100)->save($ruta);

        //Si la serie asociada al producto ha cambiado, primero se desvincula la antigua y se vincula la nueva con la descripción y la imagen y si no ha cambiado, se actualizan los datos en la relación pivot existente
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

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoUpdate', 'Asociación editada correctamente'); //redirección a la ruta pasándole el producto para listar todas las series de dicho producto con su mensaje flash
    }

    /**
     * Elimina la serie asociada al producto
     */
    public function destroy(Producto $producto, Serie $serie) //recibe un producto y una serie
    {
        $this->authorize('delete', Producto::class); //aplicando la policy
        $datosPivot = $producto->series()->where('series.id', $serie->id)->first()->pivot; //obtiene los datos del pivot correspondiente a esta serie pasada
        if ($datosPivot->imagen && Storage::disk('public')->exists($datosPivot->imagen)) { //si existe una imagen en el pivote y existe la imagen en el almacenamiento entonces...
            Storage::disk('public')->delete($datosPivot->imagen); //elimina la imagen del almacenamiento
        }

        $producto->series()->detach($serie->id); //desvincula la relación entre el producto y la serie

        if ($producto->series()->count() === 0) { //si el producto se quedó sin series...
            $carpinteria = $producto->carpinteria; //obtiene la carpintería asociada al producto
            $producto->delete(); //elimina el producto
            //redirección a la ruta pasándole la carpintería junto con el mensaje flash
            return redirect()->route('carpinterias.productos.index', $carpinteria->id)->with('successSerieProductoDelete', 'Producto eliminado por falta de series asociadas');
        }

        return redirect()->route('productos.series.index', $producto)->with('successSerieProductoDelete', 'Serie eliminada correctamente'); //redirección a la ruta pasándole el producto junto con mensaje flash
    }
}
