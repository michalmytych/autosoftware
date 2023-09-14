import Vuex from 'vuex';
import axios from 'axios';
import Vue from "vue";
import {apiRootUri} from "@/api";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        messages: [],
        selectedMessage: null
    },
    mutations: {
        SET_MESSAGES(state, messages) {
            state.messages = messages;
        },
        SET_SELECTED_MESSAGE(state, message) {
            state.selectedMessage = message;
        }
    },
    actions: {
        fetchSingleMessage({commit}, payload = {}) {
            return axios.get(`${apiRootUri}/messages/${payload.id}`)
                .then(response => {
                    commit('SET_SELECTED_MESSAGE', response.data.data);
                    console.log(response.data.data)
                })
                .catch(error => {
                    console.error('Error while fetching single message:', error);
                })
        },
        fetchMessages({commit}, payload = {}) {
            return axios.get(`${apiRootUri}/messages`, {
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
        },
        createMessage({dispatch}, payload = {}) {
            return axios.post(`${apiRootUri}/messages`, JSON.stringify(payload))
                .then(response => {
                    dispatch('fetchMessages');
                    return response;
                })
                .catch(error => {
                    if (error) {
                        alert(error)
                    }
                    console.error('Error while creating message:', error);
                })
        }
    }
});

export default store;
