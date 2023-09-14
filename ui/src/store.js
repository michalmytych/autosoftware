import Vuex from 'vuex';
import axios from 'axios';
import Vue from "vue";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        messages: []
    },
    mutations: {
        SET_MESSAGES(state, messages) {
            state.messages = messages;
        }
    },
    actions: {
        fetchMessages({commit}, payload = {}) {
            return axios.get('http://localhost:8000/messages', {
                params: {
                    page: payload.page ?? 1,
                    sorterOrder: payload.sorterOrder ?? 'DESC',
                    sorterKey: payload.sorterKey ?? 'createdAt',
                },
            })
                .then(response => {
                    commit('SET_MESSAGES', response.data);
                })
                .catch(error => {
                    console.error('Error while fetching messages:', error);
                })
        }
    }
});

export default store;
