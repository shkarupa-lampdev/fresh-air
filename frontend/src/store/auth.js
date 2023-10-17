import axios from "axios";
import router from "@/router";
//TODO: delete unused
export default {
    state: {
        user: [],
        authErrors: [],
        authStatus: false,
    },
    getters: {
        getUser: (state) => () => {
            return state.user;
        },
        getAuthErrors: (state) => () => {
            return state.authErrors;
        },
        getAuthStatus(state){
            return state.authStatus;
        },
    },
    actions: {
        async getToken() {
            await axios.get("/api/csrf-token");
        },

        async fetchUser() {
            try {
                const user = await axios.get("/api/user");
                this.commit('setAuthStatus', true);
                this.commit('setUser', user.data);
            } catch (error) {
                if (error.response.status === 401) {
                    this.commit('setAuthStatus', false);
                }
            }
        },

        async handleLogin({commit, dispatch}, form) {
            this.authErrors = [];

            try {
                await axios.post("/api/login", {
                    login: form.login,
                    password: form.password
                });
                commit('setAuthStatus', true);
                dispatch('updateAlert', {
                    status: true,
                    text: 'Ви успішно авторизувались',
                    success: true,
                })
                router.push('/');
            } catch (error) {
                console.log(error)
                commit('setAuthErrors', error.response.data.errors)
            }

        },

        async handleLogout({commit, dispatch}) {
            try{
                await axios.post("/api/logout");
                commit('setAuthStatus', false);
                dispatch('updateAlert', {
                    status: true,
                    text: 'Ви вийшли з акаунту',
                    success: true,
                })
                router.push('/');
            } catch (error) {
                console.log(error)
            }

        },
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setAuthStatus(state, status) {
            state.authStatus = status;
        },
        setAuthErrors(state, {error}) {
            state.authErrors = error
        },
    }
}




