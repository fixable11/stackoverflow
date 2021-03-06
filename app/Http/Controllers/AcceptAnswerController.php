<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class AcceptAnswerController extends Controller
{
    /**
     * Single Action Controller for marking answer as best
     *
     * @param Answer $answer
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
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
