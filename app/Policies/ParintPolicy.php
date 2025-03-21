<?php

namespace App\Policies;

use App\Models\Parint;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParintPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole(['superadmin', 'admin'])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-parents');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Parint $parint): bool
    {
        return $user->parint && $user->parint->id === $parint->id || 
               $user->can('view-parents');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-parents');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Parint $parint): bool
    {
        return ($user->parint && $user->parint->id === $parint->id && $user->can('edit-own-profile')) || 
               $user->can('edit-parents');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Parint $parint): bool
    {
        return $user->can('delete-parents');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Parint $parint): bool
    {
        return $user->can('delete-parents');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Parint $parint): bool
    {
        return $user->can('delete-parents');
    }
}
