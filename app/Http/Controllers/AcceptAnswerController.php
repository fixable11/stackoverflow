<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);
        
        if(request()->expectsJson()){
            return response()->json([
                'message' => "You have accepted this answer as best"
            ], 200);
        }
    }
}
