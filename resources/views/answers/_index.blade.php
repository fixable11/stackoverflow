
@if ($answersCount > 0)
    
    <answers class="answers" inline-template v-cloak>
        <div class="row">
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
        
            <answer @deleted="remove($event)" v-for="(item, id) in items" :answer="item" :key="item.id"></answer>
            {{-- @foreach ($answers as $answer)
                @include('answers._answer')
            @endforeach --}}
        </div>
    </answers>  
@endif