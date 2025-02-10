import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import About from '../views/About.vue'
import BudgetTable from '../views/BudgetTable.vue' // Import BudgetTable.vue

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
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
