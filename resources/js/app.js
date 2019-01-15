"use strict";
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('single-question', require('./components/SingleQuestion.vue').default);
Vue.component('author-info', require('./components/AuthorInfo.vue').default);
Vue.component('user-profile', require('./components/UserProfile.vue').default);
Vue.component('routes', require('./components/Routes.vue').default);


import VueIziToast from 'vue-izitoast';
import VeeValidate from 'vee-validate';

Vue.use(VueIziToast);
Vue.use(VeeValidate);

import {router} from './routes.js';
import {store} from './store.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
});

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



});
