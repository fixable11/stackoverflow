<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserMeta extends Model
{   

    const DEFAULT_AVATAR_PATH = '/images/no-avatar.jpg';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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
        'full_name',
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
