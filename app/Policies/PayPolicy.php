<?php

namespace App\Policies;

use App\Models\Pay;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PayPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Pay.ViewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pay $pay): bool
    {
        return $user->hasPermissionTo('Pay.View');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Pay.Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pay $pay): bool
    {
        return $user->hasPermissionTo('Pay.Update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pay $pay): bool
    {
        return $user->hasPermissionTo('Pay.Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pay $pay): bool
    {
        return $user->hasPermissionTo('Pay.Restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pay $pay): bool
    {
        return $user->hasPermissionTo('Pay.ForceDelete');
    }
}
