import axios from 'axios'
import * as Config from '../../config'

const state = {
  orders: {},
}

const actions = {

  setOrder ({commit, dispatch}, form) {
    commit('ORDER')

    return new Promise((resolve, reject) => {
      axios.post(Config.apiPath + 'order', form)
        .then(
          response => {
            commit('ORDER_OK', response.data.order)
            resolve()
          })
        .catch(error => {
          commit('ORDER_FAIL')
          reject(error.response.data)
        })
    })
  },
}

const mutations = {

  ORDER_OK (state, order) {
    state.orders = order
  },

}

export default {
  state,
  actions,
  mutations
}
