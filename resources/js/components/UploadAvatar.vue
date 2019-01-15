<template>
    <div>
        <div class="profile__avatar">
            <div class="profile__avatarWrap">
                <img :src="avatarPath" class="profile__avatarImg" alt="avatar">
            </div>

            <form v-if="auth('updateAvatar', profile)" enctype="multipart/form-data" method="POST" @submit.prevent="">
                <input id="input-avatar" type="file" accept="image/*" @change="onChange" v-show="false">
                <button @click="triggerUploadFile" type="submit" class="profile__avatarBtn">Upload new image</button>
            </form>
            
        </div>
        
    </div>
</template>

<script>


export default {
        props: {
            profile: {
                type: Object,
                required: true
            },
            defaultPath: {
                type: String,
                required: true
            }
        },
        data(){
            return {
                avatarPath: this.profile.avatar_path ? this.profile.avatar_path : this.defaultPath,
            }
        },
        computed: {

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
                axios.post(`/api/users/${this.profile.nickname}/avatar`, data)
                    .then(({data}) => {
                        console.log(data);
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