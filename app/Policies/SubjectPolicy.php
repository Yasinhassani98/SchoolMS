<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubjectPolicy
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
        return $user->can('view-subjects') || 
               $user->can('view-assigned-subjects') || 
               $user->can('view-own-subjects');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subject $subject): bool
    {
        return $user->teacher && $user->teacher->subjects->contains('id', $subject->id) ||
               $user->student && $user->student->classroom->subjects->contains('id', $subject->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-subjects');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subject $subject): bool
    {
        return $user->can('edit-subjects');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $user->can('delete-subjects');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subject $subject): bool
    {
        return $user->can('delete-subjects');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subject $subject): bool
    {
        return $user->can('delete-subjects');
    }
}
