import { RouteRecordRaw } from 'vue-router'

import { useUserStore } from 'stores/user-store'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    beforeEnter: (to, from, next) => {
      const userStore = useUserStore()
      console.log(userStore.email)
      to.fullPath === '/' ? next('/dashboard') : next()
    },
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: 'dashboard', name: 'dashboard', component: () => import('pages/IndexPage.vue') }
    ],
    meta: { requiresAuth: true }
  },
  {
    path: '/auth',
    component: () => import('layouts/AuthLayout.vue'),
    beforeEnter: (to, from, next) => {
      const userStore = useUserStore()
      !userStore.email ? next() : next(from.fullPath)
    },
    children: [
      { path: 'login', name: 'login', component: () => import('pages/auth/LoginPage.vue') },
      { path: 'register', name: 'register', component: () => import('pages/auth/RegisterPage.vue') },
      { path: 'lock-screen', name: 'lock-screen', component: () => import('pages/auth/LockScreenPage.vue') },
      { path: 'forget-password', name: 'forget-password', component: () => import('pages/auth/ForgetPasswordPage.vue') },
      { path: 'forget-password-confirm/:token', name: 'forget-password-confirm', component: () => import('pages/auth/LoginPage.vue') },
      { path: 'new-password', name: 'new-password', component: () => import('pages/auth/LoginPage.vue') }
    ],
    meta: { requiresAuth: false }
  },
  {
    path: '/form',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'forms', component: () => import('pages/forms/IndexPage.vue') },
      { path: ':id', name: 'form', component: () => import('pages/forms/FormPage.vue') }
    ],
    meta: { requiresAuth: true }
  },
  {
    path: '/account',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '/', name: 'profile', component: () => import('pages/auth/LoginPage.vue') },
      { path: 'apy-key', name: 'apy-key', component: () => import('pages/auth/LoginPage.vue') }
    ],
    meta: { requiresAuth: true }
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]
export default routes
