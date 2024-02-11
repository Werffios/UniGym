<?php

namespace App\Policies;

use App\Models\User;
use App\Models\type_client;
use Illuminate\Auth\Access\Response;

class type_clientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Fee.ViewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, type_client $typeClient): bool
    {
        return $user->hasPermissionTo('Fee.View');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Fee.Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, type_client $typeClient): bool
    {
        return $user->hasPermissionTo('Fee.Update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, type_client $typeClient): bool
    {
        return $user->hasPermissionTo('Fee.Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, type_client $typeClient): bool
    {
        return $user->hasPermissionTo('Fee.Restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, type_client $typeClient): bool
    {
        return $user->hasPermissionTo('Fee.ForceDelete');
    }
}
