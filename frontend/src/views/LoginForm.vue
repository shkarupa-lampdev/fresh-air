<template>
    <div class="login-bg h-100">
        <div class="container h-100 margntp">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card">
                            <div class="card-body">
                                <div class="logo text-center">
                                    <a href="index.html">

                                    </a>
                                </div>
                                <h4 class="text-center m-t-15">Увійти у свій аккаунт</h4>
                                <form class="m-t-30 m-b-30" @submit.prevent="loginForm()">
                                    <div class="form-group">
                                        <label>Логін</label>
                                        <input
                                            v-model="form.login"
                                            type="text"
                                            class="form-control"
                                            placeholder="Логін">
                                    </div>
                                    <div class="form-group">
                                        <label>Пароль</label>
                                        <input v-model="form.password"
                                               type="password"
                                               class="form-control"
                                               placeholder="Пароль">
                                    </div>
                                    <div class="text-center m-b-15 m-t-15">
                                        <button type="submit" class="btn btn-primary">Авторизуватись</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'vuex'
import axios from "axios";
import {ref} from "vue";

const form = ref({
    login: "",
    password: "",
})
export default {
    name: "LoginForm",
    data() {
        return {
            form,
            csrfToken: '',
        }
    },
    methods: {
        loginForm: async function () {
            await axios.get('/api/csrf-token');
            await this.$store.dispatch('handleLogin', this.form);
        }
    },
}
</script>

<style scoped>
.login-bg{
    padding-top: 100px;
    padding-bottom: 40px;
}
</style>
