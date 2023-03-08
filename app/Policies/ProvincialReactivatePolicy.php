<?php

namespace App\Policies;

use App\Models\PrReactivate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincialReactivatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrReactivate  $prReactivate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrReactivate  $prReactivate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrReactivate  $prReactivate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrReactivate  $prReactivate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrReactivate  $prReactivate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return hasSectionPermission($user, 'provincial-reactivate', 'permanently-delete');
    }
}
