<template>
    <a href="#" class="favorite mt-2" 
    :class="favoriteBulb"
    @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                isFavorited: this.question.is_favorited,
                count: this.question.favorites_count,
                id: this.question.id,
                slug: this.question.slug,
            }
        },
        computed: {
            favoriteBulb(){
                return this.signedIn ? (this.isFavorited ? 'favorited' : '') : 'off';
            },

            endpoint(){
                return `/questions/${this.slug}/favorites`;
            }
        },
        methods: {
            toggle(){
                if(!this.signedIn){
                    flash('Please sign in to favorite this question', 'info');
                } else {
                    this.isFavorited ? this.destroy() : this.create();
                }
            },

            destroy(){
                axios.delete(this.endpoint)
                .then(response => {
                    this.count--;
                    this.isFavorited = false;
                })
                .catch(error => {
                    flash(error.response.data.message, 'error');
                });
                
            },

            create(){
                axios.post(this.endpoint)
                .then(response => {
                    this.count++;
                    this.isFavorited = true;
                })
                .catch(error => {;
                    flash(error.response.data.message, 'error');
                });
               
            }
        }
    }
</script>
