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
                            <a href="#" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1232</span>
                            <a href="#" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a href="#" class="vote-accepted mt-2">
                                <i class="fas fa-check fa-2x"></i>
                            </a>
                        </div>

                        <div class="media-body answer-media-body">
                            {!! $answer->body_html !!}
                            <div class="respondent">
                                <div class="media respondent__person">
                                    <div class="text-muted">Answered {{ $answer->created_date }}</div>
                                    <div class="respondent__personBot">
                                        <a class="gravatarWrap" href="{{ $answer->user->url }}" class="pr-2">
                                            <img class="gravatar" src="{{ $answer->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body respondent__personName">
                                            <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>