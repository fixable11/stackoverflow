import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: {
            name: '', 
            meta: {
                address: '', 
                nickname: '', 
                description: '', 
                number: '', 
                social_links: '', 
                birthday: '', 
                gender: '',  
            }
        }
    },
    mutations: {
        updateUserData(state, inputData){
            
            for(let key in inputData){
                if(key == "meta") continue;
                state.user[key] = inputData[key];
            }
            for(let key in inputData.meta){
                state.user.meta[key] = inputData.meta[key];
            }

        },
        fetchUserState(state, {user}){
            state.user = user;
        },

    },
    getters: {
        fullName(state){
            return state.user.name;
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
    }
});


