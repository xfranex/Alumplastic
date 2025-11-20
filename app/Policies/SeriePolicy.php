<?php

namespace App\Policies;

use App\Models\User;

class SeriePolicy
{
    /**
     * La lista de series puede verla el administrador y el empleado
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * El proceso de creación de una serie solo puede hacerlo el administrador
     */
    public function create(User $user): bool //create store
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de actualización de una serie solo puede hacerlo el administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de eliminación de una serie solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
