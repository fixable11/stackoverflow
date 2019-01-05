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

Vue.component('author-info', require('./components/AuthorInfo.vue').default);
Vue.component('answer', require('./components/Answer.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* Check mark */
    $('.check-mark').on('click', function (event) {
        event.preventDefault();
 
        let $ths = $(this);

        let $url = $ths.data('action');

        $.ajax({
            method: "POST",
            url: $url,
            data: {}
        }).done(function (data) {
            $('.check-mark').removeClass('vote-accepted');
            $ths.addClass('vote-accepted');
        });

    });

     /* Star */
    $('.favorite').on('click', function (event) {
        event.preventDefault();
 
        let $ths = $(this);

        let $url = $ths.data('action');
        let $method = $ths.data('method');

        $.ajax({
            method: $method,
            url: $url,
            data: {}
        }).done(function (data) {
            $('.favorites-count').text(data.favorites_count);
            $ths.data('method') == "DELETE" ? $ths.data('method', 'POST') : $ths.data('method', 'DELETE');
            $ths.toggleClass('favorited');
        }).fail(function (data){
            if(data.status == 401) window.location="/login";
        });

    });

    $('.vote-up, .vote-down').on('click', function (event) {
        event.preventDefault();
 
        let $ths = $(this);

        let $url = $ths.data('action');
        let $method = $ths.data('method');

        $.ajax({
            method: $method,
            url: $url,
            data: {}
        }).done(function (data) {
            $ths.siblings('.votes-count').text(data.votes_count);
        
        }).fail(function (data){
            if(data.status == 401) window.location="/login";
        });

    });
});
