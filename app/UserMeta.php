<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserMeta extends Model
{   

    const DEFAULT_AVATAR_PATH = '/images/no-avatar.jpg';
    const AMOUNT_OF_USERS = 5;

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
    
    /**
     * Searches user by full name.
     *
     * @param string $full_name
     * @return array
     */
    public static function searchByFullName($full_name)
    {
        return UserMeta::where('full_name', 'LIKE', "$full_name%")
            ->take(self::AMOUNT_OF_USERS)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['full_name'] => $item['nickname']];
            })
            ->toArray();
    }

    /**
     * Searches user by nickname.
     * Returns tributable array
     *
     * @param string $nickname
     * @return array
     */
    public static function searchByNickName($nickname)
    {
        return UserMeta::where('nickname', 'LIKE', "$nickname%")
            ->take(self::AMOUNT_OF_USERS)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['nickname'] => $item['nickname']];
            })
            ->toArray();
    }

    /**
     * Forms array to tribute it to client side.
     * Returns tributable array
     *
     * @param [type] $collection
     * @return void
     */
    public static function arraysToTribute($collection)
    {
        $result = [];

        foreach ($collection as $key => $value) {
            array_push($result, [
                'key' => $key,
                'value' => $value
            ]);
        }

        return $result;
    }
}
