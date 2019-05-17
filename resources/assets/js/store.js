import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

// TODO dedicated store module
const store = new Vuex.Store({
    state: {
        // selected/working users & roles
        users: [],
        roles: [],
    },
    mutations: {
        addUser(state, payload) {
            let exists = state.users.find(user => user.email === payload.email)
            if (!exists) {
                state.users.push(payload)
            }
        },
        addRole(state, payload) {
            let exists = state.roles.find(role => role.name === payload.name)
            if (!exists) {
                state.roles.push(payload)
            }
        },
        removeUser(state, payload) {
            if (state.users.indexOf(payload) !== -1) {
                state.users.splice(state.users.indexOf(payload), 1)
            }
        },
        removeRole(state, payload) {
            if (state.roles.indexOf(payload) !== -1) {
                state.roles.splice(state.roles.indexOf(payload), 1)
            }
        },
    },
    getters: {
        getUsers(state) {
            return state.users
        },
        getRoles(state) {
            return state.roles
        }
    }
})

export default store
