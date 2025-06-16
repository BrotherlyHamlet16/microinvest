import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Dashboard from './components/Dashboard.vue';

const routes = [
  { path: '/', name: 'dashboard', component: Dashboard },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/invest', name: 'invest', component: InvestForm},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
