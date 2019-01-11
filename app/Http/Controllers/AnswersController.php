<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{   

    const ANSWERS_PER_PAGE = 3;
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Displays list of all answers
     *
     * @param Question $question
     * @param Request $request
     * @return void
     */
    public function index(Question $question, Request $request)
    {
        return $question->answers()->with('user')->simplePaginate(self::ANSWERS_PER_PAGE);
    }

    /**
     * Persist a newly created answer in database.
     *
     * @param Question $question
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $answer = $question->answers()->create(['body' => $request->body, 'user_id' => auth()->id()]);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been submited successfuly',
                'answer' => $answer->load('user'),
            ]);
        }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Question $question
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $request->validate([
            'body' => 'required|min:3'
        ]);

        $answer->update(['body' => $request->body]);

        if($request->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been updated successfully',
                'body_html' => $answer->body_html,
            ]);
        }
        
        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been removed',
            ]);
        }

        return back()->with('success', 'Your answer has been removed');
    }
}
