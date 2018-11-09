import axios from 'axios'
import * as Config from '../../config'

const state = {
  reports: {
    current_page: 1,
    data: [],
  },
}

const actions = {
  reportsList ({commit, dispatch}, params) {
    commit('REPORTS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'reports', {params})
        .then(
          response => {
            commit('REPORTS_OK', response.data.reports)
            resolve()
          })
        .catch(error => {
          commit('REPORTS_FAIL')
          reject(error.response.data)
        })
    })
  }
}

const mutations = {
  REPORTS_OK (state, report) {
    state.reports = report
  }
}

export default {
  state,
  actions,
  mutations
}
