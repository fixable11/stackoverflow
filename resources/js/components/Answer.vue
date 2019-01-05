<script>
export default{
    props: ['answer'],

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
            axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                body: this.body
            })
            .then(response => {
                this.bodyHtml = response.data.body_html;
                this.editState = false;
                flash(response.data.message);
            })
            .catch(error => {
                console.dir(error);
                flash(error.response.data.message, 'danger');
            });
        },
        editing(){
            this.editState = !this.editState;
            if(this.editState == false){
                this.body = this.answer.body;
            }
        },
        
    }, 
    computed: {
        isInvalid(){
            return this.body.length < 3;
        }
    },
}
</script>