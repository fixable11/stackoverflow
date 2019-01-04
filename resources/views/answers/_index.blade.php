<div class="row answers">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answersCount . " " . str_plural('Answer', $answersCount) }}</h2>
                    <hr>
                </div>
                @include('layouts._messages')
            </div>
        </div>
    </div>
   

    @foreach ($answers as $answer)
        <div class="col-md-12">
            <div class="card answer">
                <div class="card-body">
                    <div class="media answer-media">

                        <div class="vote-controls">
                            <a href="#" 
                            class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                            data-action="{{ route('answers.vote', $answer->id) }}" 
                            data-method="POST">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">{{ $answer->votes_count }}</span>
                            <a href="#" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                            data-action="{{ route('answers.unvote', $answer->id) }}"
                            data-method="DELETE">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept', $answer)
                                <a href="#" class="check-mark {{ $answer->status }} mt-2" 
                                    data-action="{{ route('answers.accept', $answer->id) }}">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            @else
                              @if ($answer->is_best)
                                <a href="#" class="{{ $answer->status }} mt-2">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                              @endif  
                            @endcan
                            
                        </div>

                        <div class="media-body answer-media-body">
                            {!! $answer->body_html !!}
                            <div class="respondent">
                                @include('shared._author', ['model' => $answer, 'text' => 'Answered'])
                                <div class="respondent__buttons">
                                    @can('update', $answer)
                                        <a class="q__edit btn btn-outline-primary btn-sm" href="{{ route('questions.answers.edit', [$question->slug, $answer->id]) }}">Edit</a>
                                    @endcan
                                    @can('delete', $answer)
                                        <form class="form-delete" method="POST" action="{{ route('questions.answers.destroy', [$question->slug, $answer->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="q__destroy btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>