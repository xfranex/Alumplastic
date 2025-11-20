<?php

namespace App\Policies;

use App\Models\User;

class ProductoPolicy
{
    /**
     * La lista de productos puede verla el administrador y el empleado
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin() || $user->esEmpleado();
    }
    
    /**
     * El detalle de un producto puede verlo el administrador y el empleado
     */
    public function view(User $user): bool //show
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * El proceso de creación de un producto solo puede hacerlo el administrador
     */
    public function create(User $user): bool //create store
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de actualización de un producto solo puede hacerlo el administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de eliminación de un producto solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
