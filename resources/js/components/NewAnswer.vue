<template>
    <div class="col-md-12">
        <div class="card newAnswer">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your answer</h3>
                </div>
                <hr>
                <form @submit.prevent="create">
                    <div class="form-group">
                        <textarea class="form-control" name="body" v-model="body" required rows="7"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" :disabled="isInvalid" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['questionSlug'],

        data(){
            return {
                body: ''
            }
        },

        computed: {
            isInvalid(){
                return !this.signedIn || this.body.length < 10;
            }
        },

        methods: {
            create(){
                axios.post(`/questions/${this.questionSlug}/answers`, {
                    body: this.body
                })
                .then(({data}) => {
                    flash(data.message, 'success');
                    this.body = '';
                    this.$emit('answerCreated', data.answer);
                })
                .catch(error => {
                    flash(error.respone.data.message, 'error');
                });
            }
        }
    }
</script>