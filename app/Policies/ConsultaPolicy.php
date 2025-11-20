<?php

namespace App\Policies;

use App\Models\User;

class ConsultaPolicy
{
    /**
     * La lista de consultas puede verla solo el administrador
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin();
    }

    /**
     * El detalle de una consulta puede verlo solo el administrador
     */
    public function view(User $user): bool //show
    {
        return $user->isAdmin();
    }

    /**
     * El proceso de eliminación de una consulta solo puede hacerlo el administrador
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
