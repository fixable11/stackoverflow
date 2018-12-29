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

    public function store(Answer $answer)
    {
        $vote = 1;
        auth()->user()->voteAnswer($answer, $vote);

        return response()->json(['votes_count' => $answer->votes_count], 200);
    }

    public function destroy(Answer $answer)
    {
        $vote = -1;
        auth()->user()->voteAnswer($answer, $vote);

        return response()->json(['votes_count' => $answer->votes_count], 200);
    }
}
