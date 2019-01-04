<div class="col-md-12">
    <div class="card answer">
        <div class="card-body">
            <div class="media answer-media">

                @include('answers._vote')

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