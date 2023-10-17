<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row title-add">
                    <h4 style="align-self: flex-start" class="card-title">Список користувачів</h4>
                    <button
                        style="align-self: flex-end; margin-right: 5px"
                        type="button"
                        class="btn btn-rounded btn-info"
                        data-toggle="modal"
                        data-target="#user-create-modal"><span class="btn-icon-left"><i class="fa fa-plus color-info"></i> </span>Add</button>
                        <!-- Add user modal start -->
                        <div id="user-create-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Створення користувача </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Закрывать"><span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="user-create-form" @submit.prevent="createUser()" >
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Ім'я</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="name"
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Логін</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="login"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Пошта</label>
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    name="email"
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Пароль</label>
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    name="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Повторіть пароль</label>
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    name="repeat-password">
                                            </div>
                                            <p class="text-danger" id="time-start">{{
                                                    alertRepeatPassword
                                                }}
                                            </p>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            form="user-create-form"
                                        >Зберегти</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add user modal end -->

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle">
                            <thead>
                            <tr>
                                <th scope="col">Логін</th>
                                <th scope="col">Пошта</th>
                                <th scope="col">Створений </th>
                                <th scope="col">Дії</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>
                                    {{ user.login }}
                                </td>
                                <td>
                                    {{ user.email  }}
                                </td>
                                <td>
                                    {{ user.created_at }}
                                </td>
                                <td>
                                    <span>
                                        <a
                                            data-toggle="modal"
                                            data-placement="top"
                                            title="Edit"
                                            data-whatever="@mdo"
                                            :data-target="'#' + 'exampleModal' + user.id">
                                            <i class="fa fa-pencil color-muted m-r-5"></i>
                                        </a>
                                        <!-- User edit modal start -->
                                        <div :id="'exampleModal' + user.id" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Редагування користувача {{user.login}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрывать"><span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form :id="'userEdit' + user.id" @submit.prevent="saveUser(user.id)">
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Ім'я</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="name"
                                                                :value="user.name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Логін</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="login"
                                                                :value="user.login">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Пошта</label>
                                                            <input
                                                                type="email"
                                                                class="form-control"
                                                                name="email"
                                                                :value="user.email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Пароль</label>
                                                            <input
                                                                type="password"
                                                                class="form-control"
                                                                name="password">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                        :form="'userEdit' + user.id"
                                                        >Зберегти</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- User edit modal end -->
                                        <a  data-toggle="modal"
                                           data-placement="top" title="Close"
                                            :data-target="'#' + 'deleteModal' + user.id">
                                            <i class="fa fa-close color-danger"></i>
                                        </a>
                                        <!-- Delete confirm modal start -->
                                        <div class="modal fade" :id="'deleteModal' + user.id" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Видалення користувача</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Ви дійсно бажаєте видалити користувача: {{user.login}}.</div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                                                        <button @click="deleteUser(user.id)"
                                                                type="button"
                                                                class="btn btn-primary"
                                                                data-dismiss="modal">Зберегти зміни</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete confirm modal end -->
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <button
                            style="margin-left: 15px; margin-top: 10px"
                            @click="logout()"
                            type="button"
                            class="btn btn-danger">Вийти з акаунту <span class="btn-icon-right"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ProfilePage",
    data() {
        return {
            users: [],
            alertRepeatPassword: '',
        };
    },
    async mounted() {
        this.loadUsers();
    },
    methods: {
        // TODO: remove methods to the new vuex storage
        async logout() {
            await this.$store.dispatch('handleLogout')
        },
        async loadUsers() {
            try {
                const response = await axios.get('/api/get-users');
                this.users = response.data.data.users;
            } catch (error) {
                console.error(error);
            }
        },
      async deleteUser(userId) {
          try {
              await axios.delete(`/api/delete-user/${userId}`);
              this.users = this.users.filter(user => user.id !== userId);
              this.$store.dispatch('updateAlert', {
                  status: true,
                  text: 'Користувача було успішно видаленно',
                  success: true,
              })
          } catch (error) {
              this.$store.dispatch('updateAlert', {
                  status: true,
                  text: 'Сталась помилка при видаленні користувача',
                  success: false,
              })
              console.error(error);
          }
      },
        async saveUser(userId) {
            const formData = new FormData(document.getElementById("userEdit" + userId));

            try {
                await axios.put(`/api/update-user/${userId}`, {
                    name: formData.get('name'),
                    login: formData.get('login'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                        });
                this.$store.dispatch('updateAlert', {
                    status: true,
                    text: 'Користувач успішно збереженний',
                    success: true,
                })
            } catch (error) {
                this.$store.dispatch('updateAlert', {
                    status: true,
                    text: 'Сталась помилка при оновлені користувача',
                    success: false,
                })
                console.error(error);
            }

            //Delete modal
            const modal = document.getElementById('exampleModal' + userId);
            modal.classList.remove('show');
            modal.classList.remove('modal-backdrop');
            modal.classList.add('modal');
            //Delete dark background
            const elements = document.querySelectorAll('.modal-backdrop');
            elements.forEach(element => {
                element.remove();
            });
        },
        async createUser() {
            const formData = new FormData(document.getElementById('user-create-form'));
            if (formData.get('password') !== formData.get('repeat-password')) {
                this.alertRepeatPassword = "Паролі не співпадають"
                return
            }

            this.alertRepeatPassword = ""

            try {
                await axios.post(`/api/create-user`, {
                    name: formData.get('name'),
                    login: formData.get('login'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                });

                this.$store.dispatch('updateAlert', {
                    status: true,
                    text: 'Користувача було успішно доданно',
                    success: true,
                })
            } catch (error) {
                this.$store.dispatch('updateAlert', {
                    status: true,
                    text: 'Сталась помилка при створенні користувача',
                    success: false,
                })
                console.error(error);
            }

            //Delete modal
            const modal = document.getElementById('user-create-modal');
            modal.classList.remove('show');
            modal.classList.remove('modal-backdrop');
            modal.classList.add('modal');
            //Delete dark background
            const elements = document.querySelectorAll('.modal-backdrop');
            elements.forEach(element => {
                element.remove();
            });
        },
    },
}
</script>

<style scoped>
.title-add{
    justify-content: space-between;
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 10px;
}
</style>
