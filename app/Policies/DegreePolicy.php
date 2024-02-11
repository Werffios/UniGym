<?php

namespace App\Policies;

use App\Models\User;
use App\Models\degree;
use Illuminate\Auth\Access\Response;

class DegreePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'Administrador']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.View');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Degree.Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.Update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.Restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, degree $degree): bool
    {
        return $user->hasPermissionTo('Degree.ForceDelete');
    }
}
