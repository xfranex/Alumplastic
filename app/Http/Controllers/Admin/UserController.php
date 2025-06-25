<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $usuarios = User::with('rol')->get();
        return view('admin.usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', User::class);
        return view('admin.usuarios.edit', ['usuario' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);
        $request->validate([
            'clave' => 'required',
        ], [
            'clave.required' => 'La contraseña es obligatoria'
        ]);

        $user->password = bcrypt($request->clave);
        $user->save();

        return redirect()->route('usuarios.index')->with('successUsuarioUpdate', 'Contraseña cambiada');
    }
}
