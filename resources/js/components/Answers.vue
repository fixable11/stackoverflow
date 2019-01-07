<template> 
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card answers-meta">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{ title }}</h2>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <answer @deleted="remove($event)" v-for="(item) in items" :answer="item" :key="item.id"></answer>

            <div class="col-md-12 mt-3 moreAnswers" v-if="nextUrl">
                <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
            </div>

            <div class="ajaxLoaderWrap" v-show="loading">
                <div class="ajaxLoader">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <new-answer @answerCreated="addNewAnswer" :question-slug="question.slug"></new-answer>
        </div>
    </div>
</template>


<script>
    import Answer from "./Answer.vue";
    import NewAnswer from "./NewAnswer.vue";
    export default {
        components: { Answer, NewAnswer },
        props: ['question'],
        data(){
            return {
                //dataSet: {}, //false,
                endpoint: location.pathname + '/answers',
                items: [],
                count: this.question.answers_count,
                nextUrl: null,
                loading: false,
            }
        },
        mounted() {
            this.fetch(this.endpoint);
        },
        created() {
            window.events.$on('bestAnswerAccepted', (bestAnswerId) => {
                
                this.items.forEach((item) => {
                    if(item.id == bestAnswerId){
                        item.is_best = true;
                    } else {
                        item.is_best = false;
                    }        
                });
            });
        },
        computed: {
            title(){
                return this.count + " " + (this.count > 1 ? "Answers" : "Answers");
            }
        },
        methods: {
            fetch(endpoint){
                this.loading = true;
                axios.get(endpoint)
                .then(this.refresh);
            },
            refresh({data}){
                this.loading = false;
                this.items.push(...data.data);
                this.nextUrl = data.next_page_url;
            },
            addNewAnswer(answer){
                this.items.push(answer);
                this.count++;
            },
            remove(index) {

                this.items = this.items.filter(function (item, i){
                    return item.id != index; 
                });

                flash('Answer was deleted', 'success');
            },
            
        }
    }
</script>