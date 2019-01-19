<template>
    <div>
        <div class="profile__avatar">
            <div class="profile__avatarWrap">
                <img :src="avatarPath" class="profile__avatarImg" alt="avatar">
            </div>

            <form v-if="auth('updateAvatar', user.meta)" enctype="multipart/form-data" method="POST" @submit.prevent="">
                <input id="input-avatar" type="file" accept="image/*" @change="onChange" v-show="false">
                <button @click="triggerUploadFile" type="submit" class="profile__avatarBtn">Upload new image</button>
            </form>
            
        </div>
        
    </div>
</template>

<script>


export default {
        props: ['specificUser'],
        data(){
            return {
                user: this.specificUser
            }
        },
        computed: {
            // user(){
            //     return this.$store.state.user;
            // },
            avatarPath(){
                return this.specificUser.meta.avatar_path;
            },
            endpoint(){
                return `/api/users/${this.user.meta.nickname}/avatar`;
            }
        },
        methods: {
            onChange(e){
                if(!e.target.files.length) return;
                let file = e.target.files[0];
                this.persist(file);
            },
            persist(avatar) {
                if(!this.signedIn){
                    flash('Please sign in to upload avatar', 'info');
                    return;
                }

                let data = new FormData();
                
                data.append('avatar', avatar);

                axios.post(this.endpoint, data)
                    .then(({data}) => {
                        
                        events.$emit('changedAvatarPath', data.path);

                        document.querySelector('.profile__avatarImg').src = data.path;
                        flash('Avatar uploaded', 'success');
                    })
                    .catch(error => {
                        flash(error.response.data.message, 'error');
                    });
            },
            triggerUploadFile(){
                let link = document.getElementById('input-avatar');
                link.click();
            }

        }
}
</script>