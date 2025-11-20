<?php

namespace App\Policies;

use App\Models\User;

class HorarioPolicy
{
    /**
     * La lista de horarios puede verla el administrador y el empleado
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * El proceso de actualización de un horario solo puede hacerlo el administrador
     */
    public function update(User $user): bool //edit update
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de activación o desactivación de un horario solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
