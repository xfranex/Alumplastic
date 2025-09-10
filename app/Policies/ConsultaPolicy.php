<?php

namespace App\Policies;

use App\Models\User;

class ConsultaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool //show
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool //destroy
    {
        return $user->isAdmin();
    }
}
