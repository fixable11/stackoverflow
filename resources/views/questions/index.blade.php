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

                    @include('layouts._messages')

                    @foreach ($questions as $question)
                            <div class="media">
                                <div class="media-body o-h">
                                    <div class="q">
                                        <h3 class="mt-0 q__title"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                        <div class="q__btngroup">
                                            @can('update', $question)
                                                <a class="q__edit btn btn-outline-primary btn-sm" href="{{ route('questions.edit', $question->id) }}">Edit</a>
                                            @endcan
                                            @can('delete', $question)
                                                <form class="form-delete" method="POST" action="{{ route('questions.destroy', $question->id) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure?')" type="submit" class="q__destroy btn btn-outline-danger btn-sm">Delete</button>
                                                </form>  
                                            @endcan 
                                        </div> 
                                    </div>
                                    <p class="lead q__meta">
                                        Asked by
                                        <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date }}</small>
                                    </p>
                                    <p>{{ str_limit($question->body, 250) }}</p>  

                                    <div class="counters">

                                        <div class="status counter {{ $question->status }}">
                                            <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count) }}
                                        </div>
                                        
                                        <div class="vote counter">
                                            <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count) }}
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
