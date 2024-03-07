import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TransactionView from '@/views/TransactionView.vue'
import InventoriView from '@/views/InventoriView.vue'
import ReportView from '@/views/ReportView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
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
