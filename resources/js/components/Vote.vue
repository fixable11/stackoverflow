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
        props: ['answer'],
        computed: {
            endpoint(){
                return `/answers/${this.id}/`;
            }
        },
        data(){
            return {
                //isBest: this.answer.is_best,
                votesCount: this.answer.votes_count || 0,
                id: this.answer.id,
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