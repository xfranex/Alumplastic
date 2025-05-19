<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\TipoProducto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiposProductos = TipoProducto::select('id', 'nombre_tipo_producto')->distinct()->get();
        $productos = Producto::with('tipoProducto')->get();
        return view('admin.productos.index', compact('productos', 'tiposProductos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposProductos = TipoProducto::select('id', 'nombre_tipo_producto')->distinct()->get();
        return view('admin.productos.create', compact('tiposProductos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'tipo_producto_id' => 'required|exists:tipos_productos,id',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'El nombre del producto ya existe.',
            'tipo_producto_id.required' => 'El tipo de producto es obligatorio.',
            'tipo_producto_id.exists' => 'El tipo de producto seleccionado no existe.',
        ]);
        Producto::create([
            'nombre' => $request->nombre,
            'tipo_producto_id' => $request->tipo_producto_id,
        ]);
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $tiposProductos = TipoProducto::select('id', 'nombre_tipo_producto')->distinct()->get();
        return view('admin.productos.edit', compact('producto', 'tiposProductos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'tipo_producto_id' => 'required|exists:tipos_productos,id',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'El nombre del producto ya existe.',
            'tipo_producto_id.required' => 'El tipo de producto es obligatorio.',
            'tipo_producto_id.exists' => 'El tipo de producto seleccionado no existe.',
        ]);
        $producto->nombre = $request->nombre;
        $producto->tipo_producto_id = $request->tipo_producto_id;
        $producto->save();
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
