<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincePolicy
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
        return hasSectionPermission($user, 'province', 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return hasSectionPermission($user, 'province', 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return hasSectionPermission($user, 'province', 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return hasSectionPermission($user, 'province', 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return hasSectionPermission($user, 'province', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return hasSectionPermission($user, 'province', 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return hasSectionPermission($user, 'province', 'permanently-delete');
    }
}
