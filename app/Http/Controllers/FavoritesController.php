<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mark question as favorite by specific user 
     *
     * @param Question $question
     * @return void
     */
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        
        if(request()->expectsJson()){
            return response()->json(null, 204);
        }
    }

     /**
     * Mark question as unfavorite by specific user 
     *
     * @param Question $question
     * @return void
     */
    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        if(request()->expectsJson()){
            return response()->json(null, 204);
        }
    }
}
