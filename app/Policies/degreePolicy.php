<?php

namespace App\Policies;

use App\Models\User;
use App\Models\degree;
use Illuminate\Auth\Access\Response;

class degreePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Degree.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Degree.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.forceDelete');
    }
}
