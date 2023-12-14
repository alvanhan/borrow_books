import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/Login.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/Register.vue')
    },
    {
      path: '/returnbook',
      name: 'returnbook',
      component: () => import('../views/dashboard/ReturnBook.vue'),
      beforeEnter: (to, from, next) => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
          next({ name: 'login' });
        } else {
          next();
        }
      },
    },
    {
      path:'/dashboard',
      name:'dashboard',
      component: () => import('../views/dashboard/Dashboard.vue'),
      beforeEnter: (to, from, next) => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
          next({ name: 'login' });
        } else {
          next();
        }
      },
    }
  ]
})

export default router
