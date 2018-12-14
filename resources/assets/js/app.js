import 'babel-polyfill'
import Vue from 'vue'
import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import axios from 'axios'
import jQuery from 'jquery'
import moment from 'moment-mini'
import store from './vuex/store' // vuex store instance
import router from './router' // vue-router instance
import 'font-awesome/css/font-awesome.css'
import './mixins'
import VueCharts from 'vue-charts'
// import VueMaterial from 'vue-material'
// import 'vue-material/dist/vue-material.min.css'
import 'vuetify/dist/vuetify.min.css'
import MultiFiltersPlugin from './plugins/MultiFilters'
import ToggleButton from 'vue-js-toggle-button'
import VueSweetalert2 from 'vue-sweetalert2'
import 'chart.js'
import 'hchs-vue-charts'

/**
 * Assing global variables
 */

window.$ = window.jQuery = jQuery
window.Vue = Vue
window.moment = moment

/**
 * Require jQuery and Vue dependant libaries
 */

require('bootstrap')
// require('vue-material/dist/vue-material.min.css')

/**
 * Vue Settings
 */

// Vue plugins
Vue.use(VueCharts)
// Vue.use(VueMaterial)
Vue.use(Vuetify, {
  iconfont: 'mdi'
})
Vue.use(MultiFiltersPlugin)
Vue.use(ToggleButton)
Vue.use(VueSweetalert2)
Vue.use(VueCharts)

// Authorization header
axios.interceptors.request.use(function (config) {
  config['headers'] = {
    Authorization: 'Bearer ' + localStorage.getItem('access_token'),
    Accept: 'application/json',
  }
  return config
}, error => Promise.reject(error))

// Show toast with message for non OK responses
axios.interceptors.response.use(response => response, error => {
  store.dispatch('addToastMessage', {
    text: error.response.data.message || 'Request error status: ' + error.response.status,
    type: 'danger'
  })
  return Promise.reject(error)
})

// Global Vue Components
Vue.component('navbar', require('./layout/Navbar.vue'))
Vue.component('sidebar', require('./layout/Sidebar.vue'))
Vue.component('spinner', require('./layout/Spinner.vue'))
Vue.component('toast', require('./layout/Toast.vue'))

/**
 * Application
 *
 * @type {Vue$2}
 */
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
})

// Check user login status
store.dispatch('checkLogin').then(() => {
  router.replace('/dashboard')
}).catch(() => {})
