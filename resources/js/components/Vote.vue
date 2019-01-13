<template>
    <div class="">
        <a href="#" @click.prevent="voteUp" class="vote-up" :class="signedIn ? '' : 'off'">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{ votesCount }}</span>
        <a href="#" @click.prevent="voteDown" class="vote-down" :class="signedIn ? '' : 'off'">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            answer: {
                type: Object,
                default: function () {
                    return {
                        default: true
                    }
                }
            },
            question: {
                type: Object,
                default: function () {
                    return {
                        default: true
                    }
                }
            },
        },
        computed: {
            endpoint(){
                if(this.answer.default){
                    return `/questions/${this.question.slug}/`;
                }
                return `/answers/${this.id}/`;
            },
            model(){
                return this.answer.default ? this.question : this.answer; 
            },
            votesCount: {
                get() {
                    return this.counter || 0;
                },
                set(newValue) {
                    this.counter = newValue;
                }
            },
            id(){
                return this.model.id;
            }   
        },
        created() {
            this.counter = this.model.votes_count;
        },
        data(){
            return {
                //isBest: this.answer.is_best,
                // votesCount: this.model.votes_count || 0,
                counter: 0,
                // id: this.model.id,
            }
        },
        methods: {
            voteUp(){
                if(!this.signedIn){
                    flash('Please sign in to vote this record','info');
                    return;
                }

                axios.post(this.endpoint + 'vote')
                .then(response => {
                    this.votesCount = response.data.votes_count;
                    flash(response.data.message, 'success');
                })
                .catch(error => {
                    flash(error.response.data.message, 'error');
                });
            },

            voteDown(){
                if(!this.signedIn){
                    flash('Please sign in to vote this record','info');
                    return;
                }

                axios.delete(this.endpoint + 'unvote')
                .then(response => {
                    this.votesCount = response.data.votes_count;
                    flash(response.data.message, 'success');
                })
                .catch(error => {
                    flash(error.response.data.message, 'error');
                });
            }
        }
        
    }
</script>