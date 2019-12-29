<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the event.
     *
     * @param  \App\User  $user
     * @param  \App\Event $event
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        return $user->is($event->owner) || $user->isAdmin();
    }
}
