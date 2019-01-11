<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vote answer up
     *
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Answer $answer)
    {
        auth()->user()->voteAnswer($answer, 1);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Thanks for feedback',
                'votes_count' => $answer->votes_count
            ], 200);
        }
    }

    /**
     * Vote answer down
     *
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Answer $answer)
    {
        auth()->user()->voteAnswer($answer, -1);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Thanks for feedback',
                'votes_count' => $answer->votes_count
            ], 200);
        }
    }
}
