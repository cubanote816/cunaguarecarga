import axios from 'axios'
import * as Config from '../../config'

const state = {
  reports: {},
}

const actions = {
  reportsList ({commit, dispatch}) {
    commit('REPORTS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'reports')
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
