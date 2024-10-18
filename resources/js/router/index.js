import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Breweries from '../components/Breweries.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: { guest: true },
  },
  {
    path: '/breweries',
    name: 'Breweries',
    component: Breweries,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next({ name: 'Login' });
  } else if (to.meta.guest && token) {
    next({ name: 'Breweries' });
  } else {
    next();
  }
});

export default router;
