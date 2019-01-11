<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class QuestionsController extends Controller
{   

    const QUESTIONS_PER_PAGE = 5;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::getPopular()->paginate(self::QUESTIONS_PER_PAGE);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your questions has been submited');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');

        $question->save();

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question);

        return view("questions.edit", compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize('update', $question);

        $question->update($request->only('body', 'title'));

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your question has been updated',
                'body_html' => $question->body_html,
                'title' => $question->title,
                'slug' => $question->slug,
            ]);
        }

        return redirect()->route('questions.index')->with('success', "Your question has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your question has been deleted',
            ]);
        }

        return redirect()->route('questions.index')->with('success', 'Your question has been deleted');
    }
}
