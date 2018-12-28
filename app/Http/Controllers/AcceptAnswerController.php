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
            
        return response()->json(['answer_id' => $answer->id], 200);
    }
}
