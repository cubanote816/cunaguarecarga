import axios from 'axios'
import { makeMutations } from '../helpers'
import * as Config from '../../config'

const state = {
  loading: false,
  dashboard: {},
  admin_dashboard: {
    fastest_run: {user: {}},
    longest_run: {user: {}},
  },
}

const actions = {

  stopLoading ({commit}) {
    commit('STOP_LOADING')
  },


  loadAdminDashboard ({commit, dispatch}) {
    commit('LOAD_ADMIN_DASHBOARD')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'dashboard/admin-data')
        .then(
          response => {
            commit('LOAD_ADMIN_DASHBOARD_OK', response.data)
            resolve()
          })
        .catch(error => {
          commit('LOAD_ADMIN_DASHBOARD_FAIL')
          reject(error.response.data)
        })
    })
  },

}

const mutations = {

  ...makeMutations([
    'CHECK_LOGIN',
    'LOGIN',
    'REGISTER',
    'UPDATE_PROFILE',
    'LOAD_ADMIN_DASHBOARD',
    'LOAD_USERS',
    'LOAD_USER',
    'UPDATE_USER',
    'DELETE_USER',
    'FINISH_CONFIRMATION',
    'LOAD_NEW_MEMBER',
    'ORDER',
  ], (state) => {
    state.loading = true
  }),

  ...makeMutations([
    'STOP_LOADING',
    'CHECK_LOGIN_OK',
    'CHECK_LOGIN_FAIL',
    'LOGIN_OK',
    'LOGIN_FAIL',
    'REGISTER_OK',
    'REGISTER_FAIL',
    'UPDATE_PROFILE_OK',
    'UPDATE_PROFILE_FAIL',
    'LOAD_ADMIN_DASHBOARD_FAIL',
    'LOAD_USERS_OK',
    'LOAD_USERS_FAIL',
    'LOAD_USER_OK',
    'LOAD_USER_FAIL',
    'UPDATE_USER_OK',
    'UPDATE_USER_FAIL',
    'DELETE_USER_OK',
    'DELETE_USER_FAIL',
    'LOAD_NEW_MEMBER_OK',
    'LOAD_NEW_MEMBER_FAIL',
    'FINISH_CONFIRMATION_OK',
    'FINISH_CONFIRMATION_FAIL',
    'ORDER_OK',
    'ORDER_FAIL',
  ], (state) => {
    state.loading = false
  }),


  LOAD_ADMIN_DASHBOARD_OK (state, dashboard) {
    state.admin_dashboard = dashboard
    state.loading = false
  },

}

export default {
  state,
  actions,
  mutations
}
