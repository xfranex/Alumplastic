<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpinteria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Carpinteria $carpinteria)
    {
        $productos = $carpinteria->productos;
        return view('admin.productos.index', ['productos' => $productos, 'carpinteria' => $carpinteria]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Carpinteria $carpinteria)
    {
        return view('admin.productos.create', ['carpinteria' => $carpinteria]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, )
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
