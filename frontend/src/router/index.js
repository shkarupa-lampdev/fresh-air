import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginForm from "@/views/LoginForm.vue";
import CsvDropzone from "@/views/CsvDropzone.vue";
import { authMiddleware, loginMiddleware } from "@/middleware/authMiddleware";
import ProfilePage from "@/views/ProfilePage.vue";
import ReportsPage from "@/views/ReportsPage.vue";
import ConstructionPage from "@/views/ConstructionPage.vue";



Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: ConstructionPage
  },
    {
        path: '/login',
        name: 'login',
        component: LoginForm,
        meta: {
            requiresAuth: true
        },
        beforeEnter: loginMiddleware
    },
    {
        path: '/reports',
        name: 'reports',
        component: ReportsPage,
        meta: {
            requiresAuth: true
        },
        beforeEnter: authMiddleware
    },
    {
        path: '/upload-csv',
        name: 'upload-csv',
        component: CsvDropzone,
        meta: {
            requiresAuth: true
        },
        beforeEnter: authMiddleware
    },
    {
        path: '/profile',
        name: 'profile',
        component: ProfilePage,
        meta: {
            requiresAuth: true
        },
        beforeEnter: authMiddleware
    },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
