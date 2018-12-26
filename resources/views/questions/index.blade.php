@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <header class="questionsHeader">
                        <h2 class="questionsHeader__title">All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                    </header>
                </div>

                <div class="card-body">
                   @foreach ($questions as $question)
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                <p class="lead">
                                    Asked by
                                    <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                    <small class="text-muted">{{ $question->created_date }}</small>
                                </p>
                                <p>{{ str_limit($question->body, 250) }}</p>  

                                <div class="counters">

                                    <div class="status counter {{ $question->status }}">
                                        <strong>{{ $question->answers }}</strong> {{ str_plural('answer', $question->answers) }}
                                    </div>
                                    
                                    <div class="vote counter">
                                        <strong>{{ $question->votes }}</strong> {{ str_plural('vote', $question->votes) }}
                                    </div>
                                    
                                    <div class="views counter">
                                        {{ $question->views }} {{ str_plural('view', $question->views) }}
                                    </div>

                                </div>

                            </div>
                        </div>
                       <hr>
                   @endforeach

                   <div class="mx-auto">
                       {{ $questions->links() }}
                   </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
