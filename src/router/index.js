import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import About from '../views/About.vue'
import BudgetTable from '../views/BudgetTable.vue' // Import BudgetTable.vue
import BudgetCharts from '../views/BudgetCharts.vue' // Import BudgetCharts.vue
import TermsAndConditions from '../views/TermsAndConditions.vue' // Import TermsAndConditions.vue
import GuestBudget from '../views/GuestBudget.vue' // Import GuestBudget.vue
import Admin from '../views/Admin.vue' // Import Admin.vue

const routes = [
  { path: '/', redirect: '/home' }, // Automatski preusmjeri na Home
  { path: '/home', name: 'Home', component: Home },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/about', name: 'About', component: About },
  {
    path: '/budget',
    name: 'BudgetTable',
    component: BudgetTable,
    meta: { requiresAuth: true }, // Ova ruta zahtijeva prijavu
  },
  {
    path: '/budget-charts', // Dodajemo novu rutu
    name: 'BudgetCharts',
    component: BudgetCharts,
    meta: { requiresAuth: true }, // Ova ruta također zahtijeva prijavu
  },
  {
    path: '/terms-and-conditions', // Dodajemo novu rutu
    name: 'TermsAndConditions',
    component: TermsAndConditions,
  },
  {
    path: '/guest-budget', // Dodajemo novu rutu za goste
    name: 'GuestBudget',
    component: GuestBudget,
  },
  {
    path: '/admin', // Dodajemo novu rutu za admina
    name: 'Admin',
    component: Admin,
    meta: { requiresAuth: true, requiresAdmin: true }, // Ova ruta zahtijeva prijavu i admin ulogu
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
