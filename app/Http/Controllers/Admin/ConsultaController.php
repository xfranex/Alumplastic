<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultas = Consulta::all();
        return view('admin.consultas.index', ['consultas' => $consultas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'telefono' => 'required|digits:9',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:5000',
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
        ]);

        if ($validacion->fails()) {
            return redirect()
                ->route('welcome')
                ->withFragment('4')
                ->withErrors($validacion)
                ->withInput();
        }

        Consulta::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'mensaje' => $request->mensaje,
        ]);
        
        return redirect()->route('welcome')->withFragment('4')->with('successContacto', 'Tu mensaje ha sido enviado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consulta $consulta)
    {
        return view('admin.consultas.show', ['consulta' => $consulta]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('successEliminadoConsulta', 'Consulta eliminada');
    }
}
