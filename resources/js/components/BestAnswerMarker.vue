<template>
    <div class="best-answer-marker">
        <a v-if="auth('markAnswerAsBest', answer)" href="#" class="check-mark mt-2" :class="isMarkedAsBest"
            @click.prevent="create">
            <i class="fas fa-check fa-2x"></i>
        </a>

        <a v-if="accepted" href="#" class="mt-2" :class="isMarkedAsBest">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['answer'],
        computed: {
            isMarkedAsBest(){
                return this.answer.is_best ? 'vote_accepted' : '';
            },
            accepted(){
                return !this.auth('markAnswerAsBest', this.answer) && this.answer.is_best;
            }

        },
        data(){
            return {
                //isBest: this.answer.is_best,
                id: this.answer.id,
            }
        },
        methods: {
            create(){
                axios.post(`/answers/${this.id}/accept`)
                .then(response => {

                    window.events.$emit('bestAnswerAccepted', this.id);

                    flash(response.data.message, 'success');
                })
                .catch(error => {
                    flash(error.response.data.message, 'error');
                });
            }
        }
        
    }
</script>
