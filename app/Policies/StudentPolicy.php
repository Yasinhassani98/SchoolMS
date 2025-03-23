<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
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
        return $user->can('view-students');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        return ($user->teacher && $user->teacher->classrooms->contains('id', $student->classroom_id)) ||
            ($user->student && $user->student->id === $student->id) ||
            ($user->parent && $user->parent->id === $student->parint_id &&
            $user->can('view-children'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-students');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {
        return $user->can('edit-students') ||
            ($user->student && $user->student->id === $student->id && $user->can('edit-own-profile'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->can('delete-students');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Student $student): bool
    {
        return $user->can('delete-students');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        return $user->can('delete-students');
    }
}
