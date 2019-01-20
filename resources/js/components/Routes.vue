<template>
    <div>
        <div class="profile-router">
            <div class="btn-group route-group" role="group" aria-label="Basic example">

                <router-link class="btn btn-secondary btn-sm" :to="{ name: 'profile', params: nickname }">
                    Profile
                </router-link>

                <router-link v-if="auth('updateProfile', specificUser)" class="btn btn-secondary btn-sm" :to="{ name: 'profile.messages', params: { nickname: nickname } }">
                    Messages
                </router-link>

                <router-link v-if="auth('updateProfile', specificUser)" class="btn btn-secondary btn-sm" :to="{ name: 'profile.settings', params: { nickname: nickname } }">
                    Settings
                </router-link>

            </div>
        </div>
        <hr>
        <router-view :specific-user="specificUser"></router-view>
    </div>
</template>
<script>
export default {
    data() {
        return {
            specificUser: {
                id: 0,
                meta:{
                    nickname: '',
                    avatar_path: '',
                    full_name: '',
                    address: '',
                    description: '',
                    number: '',
                    social_links: [],
                    birthday: '',
                    gender: '',
                }
            },
        }
    },
    created(){
        events.$on('changedAvatarPath', (newAvatarPath) => {
            this.$set(this.specificUser.meta, 'avatar_path', newAvatarPath);
        });
        this.fetchSpecificUser();
    },
    methods: {
        async fetchSpecificUser(){
            if(window.App.user && this.$route.params.nickname === window.App.user.meta.nickname){
                this.specificUser = this.$store.getters.user;
                return;
            }

            let endpoint = `/api/users/${this.$route.params.nickname}/meta`;
            await axios.get(endpoint)
                .then(({data}) => {
                    this.specificUser = data.user;
                });
        }
    },

    computed: {
        nickname() {
            return this.specificUser.meta.nickname;
        },
    }
}
</script>
