@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <header class="questionsHeader">
                        <h2 class="questionsHeader__title">Edit Question</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                        </div>
                    </header>
                </div>

                <div class="card-body">
                    <form action="{{ route('questions.update', $question->id) }}" method="POST">
                        @method('PUT')
                        @include('questions._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
