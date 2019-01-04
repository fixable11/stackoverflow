
@if ($answersCount > 0)
    
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
            @include('answers._answer')
        @endforeach
    </div>

@endif