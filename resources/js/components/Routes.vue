<template>
    <div class="btn-group route-group" role="group" aria-label="Basic example">

        <router-link class="btn btn-secondary btn-sm" :to="{ name: 'profile', params: nickname }">
            Profile
        </router-link>

        <router-link v-if="auth('updateProfile', profile)" class="btn btn-secondary btn-sm" :to="{ name: 'profile.settings', params: { nickname: nickname } }">
            Settings
        </router-link>

    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    created(){    
        this.fetchUser();
    },
    methods: {
        async fetchUser(){
            await this.$store.dispatch('fetchUser', this.$route.params.nickname);
        }
    },

    computed: {
        nickname() {
            return this.$store.getters.nickname;
        },
        profile(){
            return this.$store.getters.user;
        }
    }
}
</script>
