<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserMeta;
use App\Http\Requests\UpdateUserMetaRequest;

class UserProfileController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except(['show, fetchUser']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nickname)
    {
        $meta = UserMeta::with('user')->where('nickname', $nickname)->firstOrFail();
        
        return view('profiles.show', compact('meta'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSettings($nickname)
    {
        $profile = UserMeta::where('nickname', $nickname)->firstOrFail();

        $this->authorize('updateProfile', $profile);

        $meta = UserMeta::with('user')->where('nickname', $nickname)->firstOrFail();
        
        return view('profiles.settings', compact('meta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nickname
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserMetaRequest $request, $nickname)
    {
        $profile = UserMeta::where('nickname', $nickname)->firstOrFail();

        $this->authorize('updateProfile', $profile);

        $validated = $request->validated()['inputData'];

        if($this->persistToDatabase($validated)){

            return response()->json([
                'message' => 'Your profile has been updated'
            ], 200);

        };
        
    }

    /**
     * Persist input data to database 
     *
     * @param array $data
     * @return bool
     */
    public function persistToDatabase(array $data)
    {
        auth()->user()->update([
            'name' => $data['name'],
        ]);

        $userMeta = UserMeta::where('user_id', auth()->id())->firstOrFail();

        $userMeta->update($data['meta']);

        return $userMeta->save();
    }

    /**
     * Fetch speciific user by his nickname
     *
     * @param Request $request
     * @param  string  $nickname
     * @return \Illuminate\Http\Response
     */
    public function fetchUser(Request $request, $nickname)
    {
        $meta = UserMeta::where('nickname', $nickname)->firstOrFail();

        return response()->json([
            'user' => $meta->user
        ], 200);
    }

}
