import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/views/Login.vue';
import Home from '@/views/Home.vue';
import Expenses from '@/views/Expenses.vue';
import { toast } from '@/helpers/toast'
import { isAuthenticated } from '@/services/api'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/expenses',
            name: 'expenses',
            component: Expenses,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});

router.beforeEach(async (to, from, next) => {
    let authIsNotRequiredRoutes = [
        'login',
    ];

    if (authIsNotRequiredRoutes.includes(to.name)) {
        next()
    }

    let validAndAuthenticated = await isAuthenticated();

    if (!validAndAuthenticated) {
        toast.error('Área restrita!\n Por favor, identifique-se!');

        next({ name: 'login' });
        return;
    }

    next()
});

export default router;
