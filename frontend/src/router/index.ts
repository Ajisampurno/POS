import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TransactionView from '@/views/TransactionView.vue'
import InventoriView from '@/views/InventoriView.vue'
import ReportView from '@/views/ReportView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'Register',
      component: RegisterView
    },
    {
      path: '/',
      name: 'Transaction',
      component: TransactionView,
      meta: { requiresAuth: true },
    },
    {
      path: '/inventori',
      name: 'Inventori',
      component: InventoriView,
      meta: { requiresAuth: true },
    },
    {
      path: '/report',
      name: 'Report',
      component: ReportView,
      meta: { requiresAuth: true },
    }
  ]
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('token');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next('/login');
    } else {
      next();
    }
  } else if (to.path === '/login' || to.path === '/register') {
    if (isAuthenticated) {
      next('/');
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router
