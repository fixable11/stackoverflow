<answer :answer="{{ $answer }}" inline-template v-cloak>
    <div class="col-md-12">
        <div class="card answer">
            <div class="card-body">
                <div class="media answer-media">
    
                    @include('answers._vote')
    
                    <div class="media-body answer-media-body">
                        <form v-if="editState" method="POST" @submit.prevent="update">
                            <textarea required name="body" class="form-control" rows="5" v-model="body"></textarea>
                            <div class="answer__btn-group">
                                <button :disabled="isInvalid" type="submit" class="answer__btn btn btn-outline-primary btn-sm">Update</button>
                                <button class="answer_btn btn btn-outline-secondary btn-sm" @click.prevent="editing">Cancel</button>
                            </div>
                        </form>
                        <div v-else>
                            <div v-html="bodyHtml"></div>
                            <div class="respondent">
                                <author-info :model="{{ $answer }}" label="Answered"></author-info>
                                <div class="respondent__buttons">
                                    @can('update', $answer)
                                        <a class="q__edit btn btn-outline-primary btn-sm" @click.prevent="editing">Edit</a>
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
    </div>
</answer>