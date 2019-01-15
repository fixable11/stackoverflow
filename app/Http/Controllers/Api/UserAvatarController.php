<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\UserMeta;

class UserAvatarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new user avatar.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $nickname)
    {
        $profile = UserMeta::where('nickname', $nickname)->firstOrFail();

        $this->authorize('updateAvatar', $profile);

        $request->validate([
            'avatar' => ['required', 'image'],
        ]);

        $this->deleteOldAvatar();

        $avatarPath = $this->saveAvatar($request->file('avatar'));
        
        $this->updateAvatar($avatarPath);

        return response()->json([
            'path' => $avatarPath,
        ]);
    }

    /**
     * Saves user avatar to public directory
     *
     * @param object $image
     * @return string Avatar path
     */
    public function saveAvatar($image)
    {
        $name = time().'.'.$image->getClientOriginalExtension();

        $pathToAvatarFolder = '/images/avatars/';

        $destinationPath = public_path($pathToAvatarFolder);

        $image->move($destinationPath, $name);

        return $pathToAvatarFolder . $name;
    }

    /**
     * Deletes user's old avatar if it exists
     *
     * @return void
     */
    public function deleteOldAvatar()
    {
        $oldImage = public_path(auth()->user()->meta->avatar_path);

        if (File::exists($oldImage) && File::isFile($oldImage)) {
            unlink($oldImage);
        }
    }

    /**
     * Persists avatar path into database
     *
     * @param string $avatarPath
     * @return void
     */
    public function updateAvatar($avatarPath){
        auth()->user()->meta()->update([
            'avatar_path' => $avatarPath,
        ]);
    }
}
