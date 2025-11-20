<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * La lista de usuarios puede verla solo el administrador
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin();
    }

    /**
     * El cambio de contraseña solo puede hacerlo el administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * La activación o desactivación del usuario empleado solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
