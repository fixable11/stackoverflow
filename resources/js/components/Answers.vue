<template>
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
    </div>
</template>


<script>
    import Answer from "./Answer.vue";
    export default {
        components: { Answer },
        props: ['answers', 'count'],
        data(){
            return {
                //dataSet: {}, //false,
                endpoint: location.pathname + '/answers',
                items: [],
            }
        },
        mounted() {
            this.fetch();
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
            fetch(data){
                axios.get(this.endpoint)
                    .then(this.refresh);
            },
            refresh({data}){
                this.items = data;
            },
            add(item) {
                this.items.push(item);

                this.$emit('added');
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