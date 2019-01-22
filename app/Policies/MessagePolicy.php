<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Message;

class MessagePolicy
{
    use HandlesAuthorization;

    public function destroyIncoming(User $user, Message $message)
    {
        return $user->id === $message->receiver_id;
    }

    public function destroyOutgoing(User $user, Message $message)
    {
        return $user->id === $message->sender_id;
    }
}
