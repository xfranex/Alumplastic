<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoProducto;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo_producto' => 'required|string|max:255|unique:tipos_productos,nombre_tipo_producto',
        ], [
            'nombre_tipo_producto.required' => 'El nombre del tipo de producto es obligatorio.',
            'nombre_tipo_producto.unique' => 'El nombre del tipo de producto ya existe.',
        ]);
        TipoProducto::create([
            'nombre_tipo_producto' => $request->nombre_tipo_producto
        ]);
        return redirect()->route('productos.index')->with('successT', 'Tipo de producto creado correctamente.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoProducto $tipo)
    {
        return view('admin.tipos.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoProducto $tipo)
    {
        $request->validate([
            'nombre_tipo_producto' => 'required|string|max:255|unique:tipos_productos,nombre_tipo_producto,' . $tipo->id,
        ], [
            'nombre_tipo_producto.required' => 'El nombre del tipo de producto es obligatorio.',
            'nombre_tipo_producto.unique' => 'El nombre del tipo de producto ya existe.',
        ]);
        $tipo->nombre_tipo_producto = $request->nombre_tipo_producto;
        $tipo->save();
        return redirect()->route('productos.index')->with('successT', 'Tipo de producto actualizado correctamente.'); //poner successT en la sesion para no equivocarte con los productos
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoProducto $tipo)
    {
        $tieneProductos = $tipo->productos()->exists(); //si tiene productos asociados entonces aparece el mensaje "session('success')"
        $tipo->delete();
        if ($tieneProductos) {
            return redirect()->route('productos.index')->with('successT', 'Tipo de producto eliminado correctamente.')->with('success', 'Productos eliminados correctamente.');
        } else {
            return redirect()->route('productos.index')->with('successT', 'Tipo de producto eliminado correctamente.');
        }
    }
}
