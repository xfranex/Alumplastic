<?php

namespace App\Policies;

use App\Models\User;

class CarpinteriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool //index
    {
        return $user->isAdmin() || $user->esEmpleado();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool //create store
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool //edit update
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
