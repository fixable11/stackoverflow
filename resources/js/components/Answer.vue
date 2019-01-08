<template>
    <transition name="fade">
        <div class="col-md-12">
            <div class="card answer">
                <div class="card-body">
                    <div class="media answer-media">
                        
                        <div class="vote-controls">
                            <vote :answer="answer"></vote>
                            <best-answer-marker :answer="answer"></best-answer-marker>
                        </div>

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
                                    <author-info :model="answer" label="Answered"></author-info>
                                    <div class="respondent__buttons">
                                        <div v-if="auth('updateAnswer', answer)">
                                            <a class="q__edit btn btn-outline-primary btn-sm" @click.prevent="editing">Edit</a>
                                            <button @click="destroy" class="q__destroy btn btn-outline-danger btn-sm">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

import BestAnswerMarker from "./BestAnswerMarker.vue";
import AuthorInfo from "./AuthorInfo.vue";
import Vote from "./Vote.vue";

export default {
    props: ['answer'],
    components: { BestAnswerMarker, AuthorInfo, Vote },
    data(){
        return {
            editState: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
        }
    },
    methods: {
        update(){
            axios.patch(this.endpoint, {
                body: this.body
            })
            .then(response => {
                this.bodyHtml = response.data.body_html;
                this.editState = false;
                flash(response.data.message, 'success')
            })
            .catch(error => {
                flash(error.response.data.message, 'error');
            });
        },

        editing(){
            this.editState = !this.editState;
            if(this.editState == false){
                this.body = this.answer.body;
            }
        },

        destroy(){
            this.$toast.question('Are you sure about that?', 'Confirm',{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {

                        axios.delete(this.endpoint).then(response => {
                            if(response.status == 200){
                                this.$emit('answerDeleted', this.id);
                            }
                        });
                        this.editState = false;

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                    }],
                ],
            });
        }
        
    }, 
    computed: {
        isInvalid(){
            return this.body.length < 3;
        },
        endpoint(){
            return location.pathname + '/answers/' + this.id;
        },
    },
}
</script>

<style>
    .fade-leave-to{
        opacity: 0;
    }

    .fade-leave-active {
        transition: opacity .1s;
    }
</style>