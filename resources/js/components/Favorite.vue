<template>
    <div class="vote-controls">
        <!-- <a href="#" class="vote-up {{ Auth::guest() ? 'off' : '' }}" data-action="{{ route('questions.vote', $question->id) }}"
            data-method="POST">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{ $question->votes_count }}</span>
        <a href="#" class="vote-down {{ Auth::guest() ? 'off' : '' }}" data-action="{{ route('questions.unvote', $question->id) }}"
            data-method="DELETE">
            <i class="fas fa-caret-down fa-3x"></i>
        </a> -->
        <a href="#" class="favorite mt-2" 
        :class="favoriteBulb"
        @click.prevent="toggle"
        >
            <i class="fas fa-star fa-2x"></i>
            <span class="favorites-count">{{ count }}</span>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                isFavorited: this.question.is_favorited,
                count: this.question.favorites_count,
                id: this.question.id,
                slug: this.question.slug,
            }
        },
        computed: {
            favoriteBulb(){
                return this.signedIn ? (this.isFavorited ? 'favorited' : '') : 'off';
            },

            endpoint(){
                return `/questions/${this.slug}/favorites`;
            }
        },
        methods: {
            toggle(){
                if(!this.signedIn){
                    flash('Please sign in to favorite this question', 'info');
                } else {
                    this.isFavorited ? this.destroy() : this.create();
                }
            },

            destroy(){
                axios.delete(this.endpoint)
                .then(response => {
                    this.count--;
                    this.isFavorited = false;
                })
                .catch(error => {
                    flash(error.response.data.message, 'error');
                });
                
            },

            create(){
                axios.post(this.endpoint)
                .then(response => {
                    this.count++;
                    this.isFavorited = true;
                })
                .catch(error => {;
                    flash(error.response.data.message, 'error');
                });
               
            }
        }
    }
</script>
