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
      component: TransactionView
    },
    {
      path: '/inventori',
      name: 'Inventori',
      component: InventoriView
    },
    {
      path: '/report',
      name: 'Report',
      component: ReportView
    }
  ]
})

export default router
