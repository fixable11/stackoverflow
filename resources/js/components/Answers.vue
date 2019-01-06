<script>
    import Answer from "./Answer.vue";
    export default {
        components: { Answer },
        data(){
            return {
                //dataSet: {}, //false,
                endpoint: location.href + '/answers',
                items: [],
            }
        },
        mounted() {
            this.fetch();
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
                console.log(index);

                this.items = this.items.filter(function (item, i){
                    return item.id != index; 
                });

                flash('Reply was deleted');
            },
        }
    }
</script>