<div class="media respondent__person">
    <div class="text-muted">{{ $text }} {{ $model->created_date }}</div>
    <div class="respondent__personBot">
        <a class="gravatarWrap" href="{{ $model->user->url }}" class="pr-2">
            <img class="gravatar" src="{{ $model->user->avatar }}" alt="">
        </a>
        <div class="media-body respondent__personName">
            <a href="{{ $model->user->url }}">{{ $model->user->name }}</a>
        </div>
    </div>
</div>