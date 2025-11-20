<?php

namespace App\Policies;

use App\Models\User;

class TrabajoPolicy
{
    /**
     * La lista de trabajos puede verla el administrador y el empleado
     */
    public function viewAny(User $user): bool //index 
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * El proceso de creación de un trabajo solo puede hacerlo el administrador
     */
    public function create(User $user): bool //create store
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de actualización de un trabajo solo puede hacerlo el administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de eliminación de un trabajo solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
