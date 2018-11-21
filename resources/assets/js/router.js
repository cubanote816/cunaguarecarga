import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './vuex/store'
import {sync} from 'vuex-router-sync'
import includes from 'lodash-es/includes'

Vue.use(VueRouter)

const routes = [

  {path: '/', component: require('./pages/auth/Login.vue')},
  {path: '/login', component: require('./pages/auth/Login.vue')},
  {path: '/logout', component: require('./pages/auth/Logout.vue')},
  {path: '/register/activate/:id', component: require('./pages/auth/Confirmation.vue')},
  {path: '/register', component: require('./pages/auth/Register.vue'), meta: {requiresAuth: true}},
  {path: '/profile', component: require('./pages/auth/Profile.vue'), meta: {requiresAuth: true}},
  {path: '/order', component: require('./pages/order/Order.vue'), meta: {requiresAuth: true}},
  {path: '/dashboard', component: require('./pages/dashboard/Dashboard.vue'), meta: {requiresAuth: true}},
  {path: '/seller', component: require('./pages/seller/Seller.vue'), meta: {requiresAuth: true}},
  {path: '/seller/detail/:id', component: require('./pages/seller/SellerDetail.vue'), meta: {requiresAuth: true}},
  {path: '/reports', component: require('./pages/reports/Reports.vue'), meta: {requiresAuth: true}},


  {
    path: '/admin',
    component: require('./pages/admin/Admin.vue'),
    meta: {requiresAdmin: true},
    children: [
      {path: '', redirect: 'dashboard'},
      {path: 'dashboard', component: require('./pages/admin/dashboard/Dashboard.vue')},

      {path: 'users', component: require('./pages/admin/user/List.vue')},
      {path: 'user/show/:id', component: require('./pages/admin/user/Show.vue')},
      {path: 'user/edit/:id', component: require('./pages/admin/user/Edit.vue')},

    ]
  },

  {path: '*', component: require('./pages/404.vue')},
]


const router = new VueRouter({
  routes,
  mode: 'history',
})

// Sync Vuex and vue-router;
sync(store, router)

/**
 * Authenticated routes
 */
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && ! store.state.auth.me) {
    // if route requires auth and user isn't authenticated
    next('/login')
  } else if (to.matched.some(record => record.meta.requiresAdmin) && (! store.state.auth.me ||
      ! includes(['admin', 'manager', 'reseller', 'seller'], store.state.auth.me.role))) {
    // if route required admin or manager role
    next('/login')
  } else {
    next()
  }
})


export default router
