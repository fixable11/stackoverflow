<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMailbox extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * List of elements for mass assignment
    *
     * @var array
     */
    protected $fillable = ['user_id', 'mailbox_type'];

}
