<template>
    <table class="table table-filter outgoing">
        <tbody>
            <tr v-for="(message, index) in outgoingMessages" :key="index" class="">
                <td>
                    <div class="media">
                        <a href="#" class="outgoing__imgWrap pull-left">
                            <img :src="message.receiver.meta.avatar_path" 
                            class="outgoing__img media-photo">
                        </a>
                        <div class="media-body outgoing__body">
                            <span class="media-meta pull-right">{{ date(message.created_at) }}</span>
                            <h4 class="title">
                                {{ message.subject }}
                            </h4>
                            <p class="summary">{{ message.body }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-right">
                    <button @click="deleteMessage(message)" class="btn btn-sm btn-danger">Delete</button>
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
            return '/api/messages/outgoing';
        },

        outgoingMessages(){
            return this.$store.getters.outgoingMessages;
        },

        removeMessageEndpoint(){
            return '/api/messages/outgoing/';
        },
    },

    methods: {

        date(date){
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        },

        deleteMessage(message){

            axios.delete(this.removeMessageEndpoint + message.id)
                .then(({data}) => {
                    flash(data.message, 'success');
                    this.$store.commit('removeOutgoingMessage', message);
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