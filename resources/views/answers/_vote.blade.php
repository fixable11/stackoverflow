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
            <a href="#" class="check-mark {{ $model->status }} mt-2" 
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