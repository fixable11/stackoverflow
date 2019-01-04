@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <header class="questionsHeader">
                        <h1>{{ $question->title }}</h1>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                    </header>
                </div>

                <div class="card-body">
                   
                
                    <div class="media">

                        <div class="vote-controls">
                            <a href="#" 
                            class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                            data-action="{{ route('questions.vote', $question->id) }}" 
                            data-method="POST">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">{{ $question->votes_count }}</span>
                            <a href="#" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                            data-action="{{ route('questions.unvote', $question->id) }}"
                            data-method="DELETE">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a href="#" 
                            class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                            data-action="{{ route('questions.favorite', $question->id) }}" 
                            data-method="{{ $question->is_favorited ? 'DELETE' : 'POST' }}">
                                <i class="fas fa-star fa-2x"></i>
                                <span class="favorites-count">{{ $question->favorites_count }}</span>
                            </a>
                        </div>

                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="respondent">                                
                                @include('shared._author', [
                                    'model' => $question, 
                                    'text' => 'Asked'
                                ])
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('answers._index', [
        'answers' => $question->answers,
        'answersCount' => $question->answers_count,
    ])
    @include('answers._create')
</div>
@endsection
