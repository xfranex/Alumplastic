<?php

namespace App\Policies;

use App\Models\User;

class CarpinteriaPolicy
{
    /**
     * La lista de carpinterías pueden verla el administrador y empleado
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * El proceso de creación de una carpintería solo puede hacerlo el administrador
     */
    public function create(User $user): bool //create store
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de actualización de una carpintería solo puede hacerlo un administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de eliminación de una carpintería solo puede hacerlo un administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
