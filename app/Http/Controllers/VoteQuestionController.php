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

    public function store(Question $question)
    {
        $vote = 1;
        auth()->user()->voteQuestion($question, $vote);

        return response()->json(['votes_count' => $question->votes_count], 200);
    }

    public function destroy(Question $question)
    {
        $vote = -1;
        auth()->user()->voteQuestion($question, $vote);

        return response()->json(['votes_count' => $question->votes_count], 200);
    }

}
