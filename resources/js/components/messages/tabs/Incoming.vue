<template>
    <table class="table table-filter incoming">
        <tbody>
            <tr v-for="(message, index) in incomingMessages" :key="index" class="">
                <td>
                    <div class="media">
                        <a :href="profileUrl(message)" 
                        class="incoming__imgWrap pull-left">
                            <img :src="message.sender.meta.avatar_path" 
                            class="incoming__img media-photo">
                        </a>
                        <div class="media-body incoming__body">
                            <span class="media-meta pull-right">{{ date(message.created_at) }}</span>
                            <h4 class="title">
                                {{ message.subject }}
                            </h4>
                            <p class="summary">{{ message.body }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-right">
                    <button class="btn btn-sm btn-primary" @click="replyToMessage(message)">Reply</button>
                    <button class="btn btn-sm btn-danger" @click="deleteMessage(message)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        
    },

    data() {
        return {

        };
    },

    computed: {

        endpoint() {
            return '/api/messages/incoming';
        },

        removeMessageEndpoint(){
            return '/api/messages/incoming/';
        },

        incomingMessages(){
            return this.$store.getters.incomingMessages;
        },

    },

    methods: {

        date(date){
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        },

        profileUrl(message){
            return '/profiles/' + message.sender.meta.nickname;
        },

        replyToMessage(message){
            events.$emit('replyToMessage', message.sender.meta.nickname);
        },

        deleteMessage(message){

            axios.delete(this.removeMessageEndpoint + message.id)
                .then(({data}) => {
                    flash(data.message, 'success');
                    this.$store.commit('removeIncomingMessage', message);
                })
                .catch((error) => {
                    let errorsObj = error.response.data.errors;

                    for(let key in errorsObj){
                        errorsObj[key].forEach(value => {
                            flash(value, 'error');
                        });
                    }
                });
        }
    },  
}
</script>