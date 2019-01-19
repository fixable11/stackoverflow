<template>
    <div class="profileSettings">
        <div class="row">
            <div class="col-12">
                <h2><b>Edit</b></h2>
                <hr>
            </div>
            <div class="col">
                <form @submit.prevent="">
                    <div class="form-group">
                        <div class="lead">Full name</div>
                        <input name="fullname" 
                        v-model="inputData.meta.full_name"
                        type="text" 
                        v-validate.initial="{ required: true, regex: /^[a-z. ]+$/i }"
                        class="form-control" 
                        placeholder="Full name">
                        <div class="profileSettings__invalid">
                            {{ errors.first('fullname') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Address</div>
                        <input name="address" 
                        v-model="inputData.meta.address"
                        v-validate.initial="{ regex: /^[0-9a-z., ]+$/i }"
                        type="text" 
                        class="form-control" 
                        placeholder="Address">
                        <div class="profileSettings__invalid">
                            {{ errors.first('address') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Nickname</div>
                        <input name="nickname" 
                        v-model="inputData.meta.nickname" 
                        v-validate.initial="'required|alpha_num'"
                        type="text" 
                        class="form-control" 
                        placeholder="Nickname">
                        <div class="profileSettings__invalid">
                            {{ errors.first('nickname') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Description</div>
                        <textarea name="description"
                        v-validate.initial="{ regex: /^[0-9a-z.,+-_@ ]+$/i }"
                        rows="6"
                        v-model="inputData.meta.description"
                        class="form-control">
                        </textarea>
                        <div class="profileSettings__invalid">
                            {{ errors.first('description') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Phone</div>
                        <div class="profileSettings__phone">
                            <input name="phone" 
                            v-model="inputData.meta.number" 
                            type="text" 
                            class="form-control"
                            v-validate.initial="'digits:12'"
                            placeholder="Number">
                            <span class="profileSettings__leadingPlus">+</span>
                        </div>
                        <div class="profileSettings__invalid">{{ errors.first('phone') }}</div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Email</div>
                        <div class="profileSettings__email">
                            <input name="email"
                            readonly 
                            :value="email" 
                            type="text" 
                            class="form-control-plaintext">
                        </div>
                        <div class="profileSettings__invalid">{{ errors.first('email') }}</div>
                    </div>
                    
                    <div class="form-group">
                        <div class="profileSettings__addGroup">
                            <div class="lead">Social link(s)</div>
                            <button @click="addSocialLink" class="btn btn-success profileSettings__socialLinksBtn">
                                <span>+</span>
                            </button>
                        </div>
                        <div class="profileSettings__socialLinks">
                            <div class="profileSettings__socialLinksGroup"
                            v-for="(item, index) in inputData.meta.social_links" :key="index">
                                <small class="form-text text-muted">Title</small>

                                <input :name="'social_links[title][' + index + ']'"
                                v-model="item.title" 
                                type="text"
                                v-validate.initial="'alpha_num'"
                                class="form-control form-control-sm profileSettings__socialLink" 
                                placeholder="Social link">
                                <div class="profileSettings__invalid">
                                    {{ errors.first('social_links[title][' + index + ']') }}
                                </div>
                                <small class="form-text text-muted">Url</small>
                                <div class="d-flex">

                                    <input :name="'social_links[url][' + index + ']'"
                                    v-model="item.url" 
                                    type="text" 
                                    class="form-control form-control-sm profileSettings__socialLink" 
                                    placeholder="Social link"
                                    v-validate.initial="'required|url:require_protocol'">
                                    <button @click="removeSocialLink(index)" class="btn btn-danger profileSettings__socialLinksBtn">
                                        <span>-</span>
                                    </button>
                                </div>
                                <div class="profileSettings__invalid">
                                    {{ errors.first('social_links[url][' + index + ']') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Birthday</div>
                        <input name="birthday" 
                        v-model="inputData.meta.birthday" 
                        v-validate.initial="'date_format:YYYY-MM-DD'"
                        type="date"
                        class="form-control" 
                        placeholder="Birthday">
                        <div class="profileSettings__invalid">
                            {{ errors.first('birthday') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="lead">Gender</div>
                        <select name="gender" v-model="inputData.meta.gender" 
                        class="custom-select"
                        v-validate.initial="'included:male,female'">
                            <option disabled value="">Select one</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="profileSettings__invalid">
                            {{ errors.first('gender') }}
                        </div>
                    </div>
                    
                    <button :disabled="disabled" @click="update" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputData: {
                meta: {
                    full_name: this.user().meta.full_name,
                    address: this.user().meta.address,
                    nickname: this.user().meta.nickname,
                    description: this.user().meta.description,
                    number: this.user().meta.number,
                    social_links: this.user().meta.social_links || [],
                    birthday: this.user().meta.birthday,
                    gender: this.user().meta.gender,                
                }
           },
        }
    },
    methods: {
        user(){
            return this.$store.getters.user;
        },
        update(){

            if(!window.App.signedIn){
                flash('Please sign in to change profile', 'info');
                return;
            }

            axios.put(this.endpoint, {
                inputData: this.inputData
            })
            .then((response) => {
                this.$store.commit('updateUserData', this.inputData);
                this.$router.replace({ params: { 
                    nickname: this.inputData.meta.nickname 
                }});
                flash(response.data.message, 'success');
            })
            .catch(error => {
                flash(error.response.data.message, 'error');

                let errorsObj = error.response.data.errors;

                for(let key in errorsObj){
                    errorsObj[key].forEach(value => {
                        flash(value, 'error');
                    });
                }
            });
        },

        addSocialLink(){
            this.inputData.meta.social_links.push({
                title: '',
                url: ''
            });
        },

        removeSocialLink(index){
            this.inputData.meta.social_links.splice(index, 1);
        }

    },
    computed: {
        endpoint() {
            return `/api/users/${this.$store.getters.nickname}/meta`;
        },
        email(){
            return this.$store.getters.email;
        },
        disabled(){
            return this.errors.all().length ? true : false;
        },
        
    }
}
</script>

