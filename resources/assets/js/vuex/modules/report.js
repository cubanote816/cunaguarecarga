import axios from 'axios'
import * as Config from '../../config'

const state = {
  reports: {
    current_page: 1,
    data: [],
  },
  reports_detail: {},
  history: {},
  last20_sales: {},
  pay: {},
  status: {},
}
const getters = {
  status: state => {
    return state.status
  }
}
const actions = {
  reportsList ({commit, dispatch}, params) {
    commit('REPORTS')
    commit('REPORTS_DETAIL')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'reports', {params})
        .then(
          response => {
            commit('REPORTS_OK', response.data.reports)
            commit('REPORTS_DETAIL_OK', response.data.total_pay)
            resolve()
          })
        .catch(error => {
          commit('REPORTS_FAIL')
          commit('REPORTS_DETAIL_FAIL')
          reject(error.response.data)
        })
    })
  },
  loadHistory ({commit, dispatch}, params) {
    commit('HISTORY')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'history', {params})
        .then(
          response => {
            commit('HISTORY_OK', response.data.history)
            resolve()
          })
        .catch(error => {
          commit('HISTORY_FAIL')
          reject(error.response.data)
        })
    })
  },
  loadLast20Sales ({commit, dispatch}, params) {
    commit('LAST20_SALES')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'last20sales', {params})
        .then(
          response => {
            commit('LAST20_SALES_OK', response.data.last20)
            resolve()
          })
        .catch(error => {
          commit('LAST20_SALES_FAIL')
          reject(error.response.data)
        })
    })
  },
  loadSalesStatus ({commit, dispatch}) {
    commit('STATUS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'salesstatus')
        .then(
          response => {
            commit('STATUS_OK', response.data.status)
            resolve()
          })
        .catch(error => {
          commit('STATUS_FAIL')
          reject(error.response.data)
        })
    })
  },
  loadPay ({commit, dispatch}, params) {
    commit('PAY')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'pay', {params})
        .then(
          response => {
            commit('PAY_OK', response.data.pay)
            resolve()
          })
        .catch(error => {
          commit('PAY_FAIL')
          reject(error.response.data)
        })
    })
  },
}

const mutations = {
  REPORTS_OK (state, report) {
    state.reports = report
  },
  REPORTS_DETAIL_OK (state, detail) {
    state.reports_detail = detail
  },
  HISTORY_OK (state, histories) {
    state.history = histories
  },
  LAST20_SALES_OK (state, last20) {
    state.last20_sales = last20
  },
  STATUS_OK (state, ok) {
    state.status = ok
  },
  SALES_STATUS_OK (state, statu) {
    state.status = statu
  },
  PAY_OK (state, pay) {
    state.pay = pay
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
