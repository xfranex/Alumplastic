<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ConsultaNueva;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConsultaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Listando las consultas
     */
    public function index()
    {
        $this->authorize('viewAny', Consulta::class); //aplicando la policy
        $consultas = Consulta::all(); //coge todas las consultas de la bbdd
        return view('admin.consultas.index', ['consultas' => $consultas]); //retorna la vista pasándole todas las consultas de la bbdd
    }

    /**
     * Almacena la consulta enviada en el formulario de contacto
     */
    public function store(Request $request) //inyección de dependencias Request y son los parámetros de entrada del usuario
    {
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required|max:255|regex:/^[\pL\s\-]+$/u', //obligatorio, max 255 caracteres, patron para solo letras,espacios,guiones
            'telefono' => 'required|digits:9', //obligatorio, exactamente 9 caracteres por número de teléfono
            'email' => 'required|email|max:255', //obligatorio, formato de email, max 255 caracteres
            'mensaje' => 'required|max:5000', //obligatorio, max 5000 caracteres
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.digits' => 'El teléfono debe tener 9 dígitos',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del correo no es válido',
            'email.max' => 'El email no puede tener más de 255 caracteres',
            'mensaje.required' => 'El mensaje es obligatorio',
            'mensaje.max' => 'El mensaje no puede tener más de 5000 caracteres'
        ]); //mensajes personalizados por cada regla de validación

        if ($validacion->fails()) { //si falla la validación entonces...
            return redirect()
                ->route('welcome') //redirige a la ruta principal
                ->withFragment('contacto') //va directo al id que es #contacto para posicionarse en esta área de la web
                ->withErrors($validacion) //envía los errores a la vista para mostrarlos
                ->withInput(); //mantiene los datos ingresados
        }

        Consulta::create([ //guarda la consulta en la bbdd
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'mensaje' => $request->mensaje,
        ]);

        $data = [ //prepara los datos para enviar el correo en este array
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'mensaje' => $request->mensaje,
        ];

        Mail::to(env('EMAIL_DESTINATARIO'))->send(new ConsultaNueva($data));
        //el "to" es el destinatario del correo y envia el correo pasando el array anterior

        return redirect()->route('welcome')->withFragment('contacto')->with('successContacto', 'Tu mensaje ha sido enviado correctamente'); //redirección a la ruta con mensaje flash posicionandose en #contacto porque al enviar recarga la página y vuelve al inicio y no nos interesa
    }

    /**
     * Visualiza una consulta
     */
    public function show(Consulta $consulta) //recibe una consulta el controlador
    {
        $this->authorize('view', Consulta::class); //aplicando la policy
        return view('admin.consultas.show', ['consulta' => $consulta]); //retorna la vista y le pasa la consulta enviada a esta ruta asignada a este controlador y llama a este método
    }

    /**
     * Elimina la consulta recibida
     */
    public function destroy(Consulta $consulta) //consulta mandada a este método
    {
        $this->authorize('delete', Consulta::class); //aplicando la policy
        $consulta->delete(); //elimina de la bbdd la consulta
        return redirect()->route('consultas.index')->with('successEliminadoConsulta', 'Consulta eliminada'); //redirección a la ruta con mensaje flash
    }
}
