<template>
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
                
                this.body = data.message;
                this.level = data.level;
                console.log(this.level);
                
                this.$toast[this.level](this.body, this.ucfirst(this.level), {
                    position: 'bottomLeft',
                    timeout: 3000,
                });
            });
        }, 
        mounted(){
            // if(this.message){
            //     this.flash();
            // }
        },
        methods: {
            ucfirst(str) { 

                let f = str.charAt(0).toUpperCase();

                return f + str.substr(1, str.length - 1);

            }

        },
    }
</script>
