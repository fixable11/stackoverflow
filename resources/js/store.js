import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        ready: false,
        user: window.App.user || {
            email: '',
            meta:{
                full_name: '',
                address: '',
                nickname: '',
                avatar_path: '',
                description: '',
                number: '',
                social_links: [],
                birthday: '',
                gender: '',
            }
        },
        incomingMessages: [],
        outgoingMessages: []
    },
    mutations: {
        updateUserData(state, inputData){

            for(let key in inputData.meta){
                state.user.meta[key] = inputData.meta[key];
            }

        },
        fetchUserState(state, {user}){
            state.user = user;
            state.ready = true;
        },
        changeAvatarPath(state, newPath){
            state.user.meta.avatar_path = newPath;
        },

        addIncomingMessages(state, messages){
            state.incomingMessages = messages;
        },

        removeIncomingMessage(state, message){
            state.incomingMessages.splice(message, 1);
        },

        addOutgoingMessages(state, messages){
            state.outgoingMessages = messages;
        },

        removeOutgoingMessage(state, message){
            state.outgoingMessages.splice(message, 1);
        },

        addOutgoingMessage(state, message){
            state.outgoingMessages.push(message);
        }

    },
    getters: {
        fullName(state){
            return state.user.meta.full_name;
        },
        address(state){
            return state.user.meta.address;
        },
        nickname(state){
            return state.user.meta.nickname;
        },
        description(state){
            return state.user.meta.description;
        },
        number(state){
            return state.user.meta.number;
        },
        socialLinks(state){
            return state.user.meta.social_links;
        },
        birthday(state){
            return state.user.meta.birthday;
        },
        gender(state){
            return state.user.meta.gender;
        },
        email(state){
            return state.user.email;
        },
        user(state){
            return state.user;
        },
        readyState(state){
            return state.ready;
        },

        incomingMessages(state){
            return state.incomingMessages;
        },
        outgoingMessages(state){
            return state.outgoingMessages;
        }
    },
    actions: {
        async fetchUser ({commit}, nickname) {
            let endpoint = `/api/users/${nickname}/meta`;
            await axios.get(endpoint)
                .then(({data}) => {
                    commit('fetchUserState', data);
                });

        },
        
        async fetchMessages ({commit}) {
            let incomingEndpoint = `/api/messages/incoming`;
            let outgoingEndpoint = `/api/messages/outgoing`;

            await axios.get(incomingEndpoint)
                .then(({data}) => {
                    commit('addIncomingMessages', data);
                });

            await axios.get(outgoingEndpoint)
                .then(({data}) => {
                    commit('addOutgoingMessages', data);
                });
        },
    }
});


