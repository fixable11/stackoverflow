import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import UserProfile from './components/UserProfile.vue';
import UserProfileSettings from './components/UserProfileSettings.vue';
import Messages from './components/messages/Messages.vue';

const routes = [
    {
        name: 'profile.settings',
        path: '/profiles/:nickname/settings',
        component: UserProfileSettings,
        props: true,
    },
    {
        name: 'profile',
        path: '/profiles/:nickname',
        component: UserProfile,
        props: true
    },
    {
        name: 'profile.messages',
        path: '/profiles/:nickname/messages',
        component: Messages,
        props: true
    },
];

export const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

