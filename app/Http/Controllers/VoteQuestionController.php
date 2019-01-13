<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Vote question up
     *
     * @param Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Question $question)
    {
        auth()->user()->voteQuestion($question, 1);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Thanks for feedback',
                'votes_count' => $question->votes_count
            ], 200);
        }
    }

    /**
     * Vote question down
     *
     * @param Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Question $question)
    {
        auth()->user()->voteQuestion($question, -1);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Thanks for feedback',
                'votes_count' => $question->votes_count
            ], 200);
        }
    }

}
