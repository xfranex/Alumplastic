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
     * Lista todos los usuarios 
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); //aplicando la policy
        $usuarios = User::with('rol')->get(); //recoge todos los usuarios junto con la relación 'rol'
        return view('admin.usuarios.index', ['usuarios' => $usuarios]); //retorna la vista pasándole todos los usuarios
    }

    /**
     * Formulario para cambiar la contraseña
     */
    public function edit(User $user) //recibe el user
    {
        $this->authorize('update', User::class); //aplicando la policy
        return view('admin.usuarios.edit', ['usuario' => $user]); //retorna la vista pasándole el usuario seleccionado candidato a cambiar su contraseña
    }

    /**
     * Método para completar el cambio de contraseña y ser efectivo
     */
    public function update(Request $request, User $user) //recibe la contraseña que es el parámetro y el usuario
    {
        $this->authorize('update', User::class); //aplicando la policy
        $request->validate([
            'clave' => 'required', //obligatorio introducir la contraseña
        ], [
            'clave.required' => 'La contraseña es obligatoria' //mensaje en caso de que se encuentre vacío
        ]);

        $user->password = bcrypt($request->clave); //cambiando la contraseña del usuario y colocándola en bcrypt ya que laravel lo necesita sin esto se guarda como texto en plano en la bbdd y es peligroso asi solo se guarda el hash
        $user->save(); //guardamos el usuario

        return redirect()->route('usuarios.index')->with('successUsuarioUpdate', 'Contraseña cambiada'); //redirección a la ruta con mensaje flash
    }

    /**
     * Activa o desactiva el usuario empleado para decidir si queremos o no queremos que haga login
    */
    public function destroy(User $user) //recibe user
    {
        $this->authorize('delete', User::class); //aplicando la policy
        if($user->id === 2 && $user->rol_id === null) { //si el id es el 2 y su rol_id es null entonces el usuario empleado...
            $user->rol_id = 2; //cambiamos el campo de su rol al id 2 que es rol empleado y en la policy esto lo tiene en cuenta y en el login
            $user->save(); //guardamos el usuario
            return redirect()->route('usuarios.index')->with('successUsuarioDelete','Usuario activado'); //redirección a la ruta con mensaje flash
        }
        
        if($user->id === 2 && $user->rol_id === 2) { //si el usuario tiene el id 2 y en el campo rol_id tiene 2 entonces lo vamos a desactivar
            $user->rol_id = null; //le colocamos su rol_id a null esto se tiene muy en cuenta en otros archivos
            $user->save(); //guardamos el usuario
            return redirect()->route('usuarios.index')->with('successUsuarioDelete','Usuario desactivado'); //redirección a la ruta con mensaje flash
        }
    }
}
