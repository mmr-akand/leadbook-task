import Home from './components/Home.vue';
import Search from './components/Search.vue';
import Login from './components/auth/Login.vue';

export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/search',
        component: Search,
        meta: {
            requiresAuth: true
        },
    }
];