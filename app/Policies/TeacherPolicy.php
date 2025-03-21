<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeacherPolicy
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
        return $user->can('view-teachers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Teacher $teacher): bool
    {
        return $user->teacher && $user->teacher->id === $teacher->id || 
               $user->student && $user->student->classroom->teachers->contains('id', $teacher->id) ||
               $user->can('view-teachers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-teachers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Teacher $teacher): bool
    {
        return ($user->teacher && $user->teacher->id === $teacher->id && $user->can('edit-own-profile')) || 
               $user->can('edit-teachers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->can('delete-teachers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Teacher $teacher): bool
    {
        return $user->can('delete-teachers');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Teacher $teacher): bool
    {
        return $user->can('delete-teachers');
    }
}
