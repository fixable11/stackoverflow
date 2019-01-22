<template>
    <div class="profileMessages">
        <div class="row">
            <tabs class="col-12">

                <tab name="Incoming" :selected="true">
                    <incoming></incoming>
                </tab>

                <tab name="Outgoing">
                    <outgoing></outgoing>
                </tab>

                <tab name="In trash">
                    <trash></trash>
                </tab>

                <tab name="Send message">
                    <send-message></send-message>
                </tab>

            </tabs>

            
        </div>
    </div>
</template>

<script>
import SendMessage from './tabs/SendMessage.vue';
import Incoming from './tabs/Incoming.vue';
import Outgoing from './tabs/Outgoing.vue';
import Trash from './tabs/Trash.vue';
import Tabs from './Tabs.vue';
import Tab from './Tab.vue';
export default {
    components: {
        SendMessage, 
        Tabs, 
        Tab, 
        Incoming,
        Outgoing,
        Trash
    },
    created(){
        this.$store.dispatch('fetchMessages');
    },
    data() {
        return {
            
        }
    },
    methods: {
        
    },
    computed: {
     
        
    }
}
</script>