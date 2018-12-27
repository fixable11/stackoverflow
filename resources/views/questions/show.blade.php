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
                            <a href="#" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1232</span>
                            <a href="#" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a href="#" class="favorite mt-2 favorited">
                                <i class="fas fa-star fa-2x"></i>
                                <span class="favorites-count">123</span>
                            </a>
                        </div>

                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="respondent">                                
                                <div class="media respondent__person">
                                    <span class="text-muted">Asked {{ $question->created_date }}</span>
                                    <div class="respondent__personBot">
                                        <a class="gravatarWrap" href="{{ $question->user->url }}" class="pr-2">
                                            <img class="gravatar" src="{{ $question->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body respondent__personName">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row answers">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $question->answers_count . " " . str_plural('Answer', $question->answers_count) }}</h2>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($question->answers as $answer)
            <div class="col-md-12">
                <div class="card answer">
                    <div class="card-body">
                        <div class="media">

                            <div class="vote-controls">
                                <a href="#" class="vote-up">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">1232</span>
                                <a href="#" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <a href="#" class="vote-accepted mt-2">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="respondent">
                                    <div class="media respondent__person">
                                        <div class="text-muted">Answered {{ $answer->created_date }}</div>
                                        <div class="respondent__personBot">
                                            <a class="gravatarWrap" href="{{ $answer->user->url }}" class="pr-2">
                                                <img class="gravatar" src="{{ $answer->user->avatar }}" alt="">
                                            </a>
                                            <div class="media-body respondent__personName">
                                                <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
