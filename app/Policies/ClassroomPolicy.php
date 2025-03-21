<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
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
        return $user->can('view-classrooms') || 
               $user->can('view-assigned-classrooms') || 
               $user->can('view-own-classroom') ||
               $user->can('view-children-classrooms');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Classroom $classroom): bool
    {
        return $user->can('view-classrooms') || 
               ($user->hasRole('teacher') && $user->teacher && $user->teacher->classrooms->contains('id', $classroom->id)) ||
               ($user->hasRole('student') && $user->student && $user->student->classroom_id === $classroom->id) ||
               ($user->hasRole('parint') && $user->parint && $user->parint->students->contains('classroom_id', $classroom->id));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-classrooms');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return $user->can('edit-classrooms');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $user->can('delete-classrooms');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Classroom $classroom): bool
    {
        return $user->can('delete-classrooms');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Classroom $classroom): bool
    {
        return $user->can('delete-classrooms');
    }
}
