<template>
    <div>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/></svg>
        </div>
    </div>
    <div id="main-wrapper">

        <NavigationSideBar
            v-if="!$route.path.startsWith('/login') && isLoggedIn "/>
        <router-view/>
        <notification-alert v-if="alertShow" :message="alertText" :is-success="alertSuccess"></notification-alert>
    </div>
    </div>
</template>
<script>
import NavigationSideBar from "@/components/NavigationSideBar.vue";
import NotificationAlert from "@/components/NotificationAlert.vue";



export default {
    data () {
        return{
            isLoggedIn: false,
            alertShow: false,
            alertText: 'lol',
            alertSuccess: true,
        }
    },
    components: {
        NavigationSideBar,
        NotificationAlert
    },
    mounted() {
        this.$store.dispatch('fetchUser');
    },
    watch: {
        '$store.getters.getAuthStatus': function(newStatus) {
            this.isLoggedIn = newStatus;
        },
        '$store.getters.getAlertShow': function(newStatus) {
            this.alertShow = newStatus;
        },
        '$store.getters.getAlertText': function(newStatus) {
            this.alertText = newStatus;
        },
        '$store.getters.getAlertSuccess': function(newStatus) {
            this.alertSuccess = newStatus;
        },
    },
}
</script>
