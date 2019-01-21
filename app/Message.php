<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    /**
     * List of elements for mass assignment
    *
     * @var array
     */
    protected $fillable = ['body', 'subject', 'receiver_id', 'sender_id'];


    /**
     * Message sender
     *
     * @return App\User
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Message receiver
     *
     * @return App\User
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Message's mailbox
     * It's a table which determines message status consider specific user
     *
     * @return App\UserMailbox
     */
    public function mailbox()
    {
        return $this->hasOne(UserMailbox::class, 'message_id');
    }

    /**
     * Fetches user's mailbox or creates a new one if it does not exist
     *
     * @param User $user
     * @return App\UserMailbox
     */
    protected function fetchUserMailbox(User $user)
    {
        return $this->mailbox()
            ->firstOrCreate([
                'user_id' => $user->id
            ]);
    }

    /**
     * Sets message status to 'incoming'
     *
     * @param User $user
     * @return void
     */
    public function setStatusToIncoming(User $user)
    {
        $mailbox = $this->fetchUserMailbox($user);
        
        $mailbox->update([
            'mailbox_type' => 'In'
        ]);     
    }

    /**
     * Sets message status to 'outgoing'
     *
     * @param User $user
     * @return void
     */
    public function setStatusToOutgoing(User $user)
    {
        $mailbox = $this->fetchUserMailbox($user);
        
        $mailbox->update([
            'mailbox_type' => 'Out'
        ]);
    }

    /**
     * Sets message status to 'trash'
     *
     * @param User $user
     * @return void
     */
    protected function setStatusToTrash(User $user)
    {
        $mailbox = $this->fetchUserMailbox($user);
        
        $mailbox->update([
            'mailbox_type' => 'Trash'
        ]);
    }

}
