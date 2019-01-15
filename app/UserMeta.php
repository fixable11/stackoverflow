<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserMeta extends Model
{

    protected $casts = [
        'social_links' => 'array',
        'nickname' => 'string'
    ];

    protected $primaryKey = 'nickname';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nickname'];

    /**
     * User one-to-one relation.
     * Returns User instance
     *
     * @return App\User;
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avatarPath(){
        return $this->avatar_path ?: '/images/no-avatar.jpg';
    }    
}
