<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User $givenUser
     * @return mixed
     */
    public function delete(User $user, User $givenUser)
    {
        return $user->isNot($givenUser);
    }
}
