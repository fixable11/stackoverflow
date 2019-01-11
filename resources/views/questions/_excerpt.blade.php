
<div class="question">
    <div class="media">
            <div class="media-body o-h">
                <div class="q">
                    <h3 class="mt-0 q__title"><a href="{{ route('questions.show', $question->slug) }}">{{ $question->title }}</a></h3>
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
                <p class="excerpt">{{ $question->excerpt(250) }}</p>  

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
</div>