<?php

namespace App\Policies;

use App\User;
use App\UserMeta;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserMetaPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can update his avatar
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return bool
     */
    public function updateAvatar(User $user, UserMeta $userMeta){
        return $user->id === $userMeta->user_id;
    }

    /**
     * Determine whether the user can view the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function view(User $user, UserMeta $userMeta)
    {
        //
    }

    /**
     * Determine whether the user can create user metas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function update(User $user, UserMeta $userMeta)
    {
        //
    }

    /**
     * Determine whether the user can delete the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function delete(User $user, UserMeta $userMeta)
    {
        //
    }

    /**
     * Determine whether the user can restore the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function restore(User $user, UserMeta $userMeta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function forceDelete(User $user, UserMeta $userMeta)
    {
        //
    }
}
