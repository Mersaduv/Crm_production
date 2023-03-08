<?php

namespace App\Policies;

use App\Models\NOC;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NocPolicy
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
        return hasSectionPermission($user, 'installation', 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NOC $noc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return hasSectionPermission($user, 'installation', 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return hasSectionPermission($user, 'installation', 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NOC $noc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return hasSectionPermission($user, 'installation', 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NOC $noc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return hasSectionPermission($user, 'installation', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NOC $noc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return hasSectionPermission($user, 'installation', 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NOC $noc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return hasSectionPermission($user, 'installation', 'permanently-delete');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function cancel(User $user)
    {
        return hasSectionPermission($user, 'installation', 'cancel');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function rollbackcCancel(User $user)
    {
        return hasSectionPermission($user, 'installation', 'rollback-cancel');
    }
}
