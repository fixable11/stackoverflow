<template>
    <div class="profile">
        <div class="row">
            <div class="col-lg-4">

                <upload-avatar :specificUser="specificUser"></upload-avatar>

                <div class="profile__address"></div>
                
            </div>
            <div class="col-lg-8">
                <div class="profile__header">
                    <h3 class="profile__fullname">{{ fullName }}</h3>
                </div>
                <div class="profile__location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="profile__locationAddress">{{ address }}</span>
                </div>
                <div class="profile__nickname">
                    <h5>{{ nickname }}</h5>
                </div>
                <div class="profileAbout">
                    <div class="profileAbout__title">
                        <i class="profileAbout__titleIcon fas fa-user"></i>
                        <span class="profileAbout__titleSpan">About</span>
                    </div>
                    <div class="profileAbout__description">
                        {{ description }}
                    </div>
                    <div class="contactInfo">
                        <div class="contactInfo__title">Contact information</div>
                        <div class="contactInfo__item">
                            <div class="contactInfo__name">Email</div>
                            <span class="contactInfo__email contactInfo__value">
                                {{ email }}
                            </span>
                        </div>
                        <div class="contactInfo__item">
                            <div class="contactInfo__item">
                                <div class="contactInfo__name">Phone</div>
                                <a href="tel:+496170961709" class="contactInfo__value contactInfo__phone">{{ number }}</a>
                            </div>
                        </div>
                        <div class="contactInfo__item">
                            <div class="contactInfo__item">
                                <div class="contactInfo__name">Sites</div>
                                <ul class="contactInfo__sites contactInfo__value">
                                    <li v-for="(link, index) in socialLinks" class="contactInfo__site" :key="index">
                                        <a :href="link.url">{{ link.title }}</a>
                                        <span v-if="whetherLastElement(index, socialLinks)">,&nbsp;</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contactInfo__title">Basic information</div>
                        <div class="contactInfo__item">
                            <div class="contactInfo__item">
                                <div class="contactInfo__name">Birthday</div>
                                <div class="contactInfo__value contactInfo__birthday">{{ birthday }}</div>
                            </div>
                        </div>
                        <div class="contactInfo__item">
                            <div class="contactInfo__item">
                                <div class="contactInfo__name">Gender</div>
                                <div class="contactInfo__value contactInfo__gender">{{ gender }}</div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
            
        </div>
    </div>
</template>


<script>
import UploadAvatar from "./UploadAvatar.vue";

export default {
    components: { UploadAvatar },
    props: ['specificUser'],
    
    data() {
        return {
           
        }
    },
    methods: {
        whetherLastElement(index, array){
            return index != (array.length - 1);
        },
    },
    computed: {
        user(){
            if(window.App.user && this.specificUser.id === window.App.user.id){
                return this.$store.getters.user;
            }
            return this.specificUser;
        },
        fullName(){
            return this.user.meta.full_name;
        },
        address(){
            return this.user.meta.address;
        },
        nickname(){
            return this.user.meta.nickname;
        },
        description(){
            return this.user.meta.description;
        },
        number(){
            return this.user.meta.number;
        },
        socialLinks(){
            return this.user.meta.social_links;
        },
        birthday(){
            return this.user.meta.birthday;
        },
        gender(){
            return this.user.meta.gender;
        },
        email(){
            return this.user.email;
        },

    }
}
</script>