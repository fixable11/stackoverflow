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
     * Determine whether the user can update the user meta.
     *
     * @param  \App\User  $user
     * @param  \App\UserMeta  $userMeta
     * @return mixed
     */
    public function updateProfile(User $user, UserMeta $userMeta)
    {
        return $user->id === $userMeta->user_id;
    }

}
