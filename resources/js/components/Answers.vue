<script>
    import Answer from "./Answer.vue";
    export default {
        components: { Answer },
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