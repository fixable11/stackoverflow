<template>
    <transition name="fade">
        <div class="alert alert-flash" :class="'alert-' + level" v-show="show" v-text="body"></div>
    </transition>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                body: this.message,
                level: 'success',
                show: false,
            }
        },
        created(){
            window.events.$on('flash', (data) => {
                this.flash(data);
            });
        }, 
        mounted(){
            if(this.message){
                this.flash();
            }
        },
        methods: {
            flash(data = false){
                if(data){
                    this.body = data.message;
                    this.level = data.level;
                }
                
                this.show = true;

                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },

        },
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        left: 25px;
        bottom: 25px;
    }

    .fade-enter-active{
        transition: opacity .5s;
    }

    .fade-enter-to{
        opacity: 1;
    }

    .fade-enter,
    .fade-leave-to{
        opacity: 0;
    }

    .fade-leave-active {
       transition: opacity 1s;
    }
</style>