@extends('layouts.app')

@section('content')
<single-question :question="{{ $question }}" 
                v-cloak
                :new-question-route="'{{ route('questions.create') }}'">
</single-question>
@endsection
