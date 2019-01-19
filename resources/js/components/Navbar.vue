<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="/">
                {{ 'Laravel' }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <div v-if="!signedIn">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/login">{{ 'Login' }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/register">{{ 'Register' }}</a>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ nickname }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" :href="profileUrl">
                                    {{ 'My profile' }}
                                </a>

                                <a @click.prevent="logout" class="dropdown-item" href="/logout">
                                    {{ 'Logout' }}
                                </a>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            signedIn: window.App.signedIn 
        }
    },
    methods: {
        logout(){
            axios.post('/logout')
                .then(() => {
                    this.signedIn = false;
                    window.App.signedIn = false;
                });
        }
    },
    computed: { 
        nickname(){
            return this.$store.getters.nickname;
        },
        profileUrl(){
            return '/profiles/' + this.nickname;
        },
    }

}
</script>