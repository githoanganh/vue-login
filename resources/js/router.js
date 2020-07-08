import Vue from 'vue'
import VueRouter from 'vue-router';
import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
Vue.use(VueRouter);
const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/register',
        component: Register,
        meta: {
            auth: false
        }
    },
]
const router = new VueRouter({
    mode: 'history',
    routes
})
export default router