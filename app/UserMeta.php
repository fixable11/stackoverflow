<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserMeta extends Model
{   

    const DEFAULT_AVATAR_PATH = '/images/no-avatar.jpg';

    protected $casts = [
        'social_links' => 'array',
        'nickname' => 'string'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //'avatar_path'
    ];

    protected $primaryKey = 'nickname';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'description',
        'avatar_path',
        'birthday',
        'gender',
        'number',
        'address',
        'social_links',
    ];

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

    public function getAvatarPathAttribute($avatar_path){
        return $avatar_path ?: self::DEFAULT_AVATAR_PATH;
    }    
}
