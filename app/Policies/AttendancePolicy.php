<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
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
        return $user->can('view-attendances') || 
               $user->can('view-own-attendances') || 
               $user->can('view-children-attendances');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        return $user->can('view-attendances') || 
               ($user->can('view-own-attendances') && $user->teacher && $user->teacher->id === $attendance->teacher_id) || 
               ($user->can('view-own-attendances') && $user->student && $user->student->id === $attendance->student_id) ||
               ($user->can('view-children-attendances') && $user->parint && $user->parint->students->contains('id', $attendance->student_id));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-attendances') || $user->can('create-own-attendances');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        return $user->can('edit-attendances') || 
               ($user->can('edit-own-attendances') && $user->teacher && $user->teacher->id === $attendance->teacher_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->can('delete-attendances');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendance $attendance): bool
    {
        return $user->can('delete-attendances');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendance $attendance): bool
    {
        return $user->can('delete-attendances');
    }
}
