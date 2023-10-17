<template>
    <div class="nk-sidebar">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu">
                <li class="nav-label">Main</li>
                <li><router-link to="/"><i class=" mdi mdi-view-dashboard"></i> <span class="nav-text">Головна сторінка</span></router-link>
                </li>
                <li><router-link to="/upload-csv"><i class=" mdi mdi-widgets"></i> <span class="nav-text">Внести дані </span></router-link>
                </li>
                <li><router-link to="/reports"><i class="mdi mdi-table-edit"></i> <span class="nav-text">Завантажити звіти </span></router-link>
                </li>
            </ul>
            <div
                class="login-icon">
                <ul>

                    <li class="icons"><router-link to="/profile"><a href="javascript:void(0)"><i class="mdi mdi-account f-s-20" aria-hidden="true"></i></a>
                        <div class="drop-down dropdown-profile animated bounceInDown">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li><router-link to="/profile"><i class="mdi mdi-settings"></i> <span>Inbox</span></router-link>
                                    </li>
                                    <li @click="logout()"><i class="icon-power"></i> <span>Logout</span>
                                    </li>
                                </ul>
                            </div>
                        </div> </router-link>
                    </li>

                </ul>
            </div>
        </div>
        <!-- #/ nk nav scroll -->
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "NavigationSideBar",

    methods: {
        async logout() {
            try {
                await axios.post('/api/logout');
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>

<style scoped>
.nk-nav-scroll{
    display: flex;
    justify-content: space-between;
}
.login-icon{
    padding-top: 10px;
    margin-right: 20px;
}
</style>
