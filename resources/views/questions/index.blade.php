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

                    @forelse ($questions as $question)
                            @include('questions._excerpt')
                    @empty
                        <div class="alert alert-warning">
                            <p>There is nothing here</p>
                        </div>
                    @endforelse

                   <div class="mx-auto">
                       {{ $questions->links() }}
                   </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
