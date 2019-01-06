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

                    <favorite :question="{{ $question }}"></favorite>

                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="respondent">                                
                                <author-info :model="{{ $question }}" label="asked"></author-info>
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
