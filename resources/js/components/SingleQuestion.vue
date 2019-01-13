<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <form class="card" v-if="editState" @submit.prevent="update">

                    <div class="card-header">
                        <header class="questionsHeader">
                            <input type="text" class="form-control form-control-lg" v-model="title">
                        </header>
                    </div>

                    <div class="card-body">
                        <div class="media">

                            <div class="media-body">
                                <textarea required name="body" class="form-control" rows="5" v-model="bodyHtml"></textarea>
                                <div class="answer__btn-group">
                                    <button :disabled="isInvalid" type="submit" class="answer__btn btn btn-outline-primary btn-sm">Update</button>
                                    <button class="answer_btn btn btn-outline-secondary btn-sm" @click.prevent="editing">Cancel</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

                <div class="card" v-else>

                    <div class="card-header">
                        <header class="questionsHeader">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <a :href="newQuestionRoute" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </header>
                    </div>

                    <div class="card-body">        
                        <div class="media">
                        
                        <div class="vote-controls">
                            <favorite :question="question"></favorite>

                            <vote :question="question"></vote>
                        </div>

                            <div class="media-body">
                                <div v-html="bodyHtml"></div>
                                <div class="respondent">                                
                                    <author-info :model="question" label="asked"></author-info>
                                    <div v-if="auth('updateQuestion', question)">
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
        <answers :question="question"></answers>
    </div>
</template>

<script>
import Answers from "./Answers.vue";
import Favorite from "./Favorite.vue";
import Vote from "./Vote.vue";

export default {
    components: { Answers, Favorite, Vote },
    props: ['question', 'newQuestionRoute'],
    data() {
        return {
            editState: false,
            slug: this.question.slug,
            title: this.question.title,
            bodyHtml: this.question.body_html,
            editCache: {
                title: this.question.title,
                bodyHtml: this.question.body_html,
            },
        }
    },
    methods: {
        editing(){
            this.editState = !this.editState;
            if(this.editState == false){
                this.bodyHtml = this.editCache.bodyHtml;
                this.title = this.editCache.title;
            }
        },

        update(){
            axios.put(this.endpoint, {
                body: this.bodyHtml,
                title: this.title,
            })
            .then(({data}) => {
                window.events.$emit('changedUrl', '/questions/' + data.slug);

                this.title = data.title;
                this.bodyHtml = data.body_html

                this.editCache = {title: this.title, bodyHtml: this.bodyHtml };

                window.history.pushState({}, "page", "/questions/" + data.slug);

                this.editState = false;
                flash(data.message, 'success');
            })
            .catch((error) => {
                flash(error.response.data.message, 'error');
            });
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

                        axios.delete(this.endpoint)
                        .then(response => {
                            if(response.status == 200 || response.status == 204){
                                flash(response.data.message, 'success');
                            }
                        });
                        this.editState = false;


                        setTimeout(() => {
                            window.location.href = '/questions';
                        }, 3000);

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
            return this.bodyHtml.length < 5 || this.title.length < 5;
        },

        endpoint(){
            return `/questions/${this.slug}`;
        },

    }
}
</script>