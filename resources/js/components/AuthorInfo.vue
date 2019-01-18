<template>
    <div class="media respondent__person">
        <div class="text-muted">{{ postDate }}</div>
        <div class="respondent__personBot">
            <a class="gravatarWrap pr-2" :href="user.url">
                <img class="gravatar" :src="user.meta.avatar_path" alt="img">
            </a>
            <div class="media-body respondent__personName">
                <a :href="user.url">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model', 'label'],
        computed: {
            postDate(){
                return this.label + " " + this.model.created_date;
            }
        },
        data(){
            return {
                user: this.model.user,
            }
        }
    }
</script>
