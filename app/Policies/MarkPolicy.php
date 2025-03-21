<?php

namespace App\Policies;

use App\Models\Mark;
use App\Models\User;

class MarkPolicy
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
        return $user->can('view-marks') ||
            $user->can('view-own-marks') ||
            $user->can('view-children-marks');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mark $mark): bool
    {
        return $user->teacher && $user->teacher->id === $mark->teacher_id ||
            $user->student && $user->student->id === $mark->student_id ||
            $user->parint && $user->parint->students->contains('id', $mark->student_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-marks') || 
            $user->can('create-own-marks');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mark $mark): bool
    {
        return ($user->teacher && $user->teacher->id === $mark->teacher_id && $user->can('edit-marks')) ||
            $user->can('edit-marks') ||
            $user->can('edit-own-marks');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mark $mark): bool
    {
        return $user->can('delete-marks');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mark $mark): bool
    {
        return $user->can('delete-marks');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mark $mark): bool
    {
        return $user->can('delete-marks');
    }
}
