import axios from 'axios'
import * as Config from '../../config'

const state = {
  sellers: {},
  seller_detail: {
    current_page: 1,
    data: [],
  },
}

const actions = {

  getSellers ({commit, dispatch}) {
    commit('SELLER')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'getsellers')
        .then(
          response => {
            commit('SELLER_OK', response.data.sellers)
            resolve()
          })
        .catch(error => {
          commit('SELLER_FAIL')
          reject(error.response.data)
        })
    })
  },

  getSellerDetail ({commit, dispatch}, params) {
    commit('SELLERDETAIL')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'seller/detail', {params})
        .then(
          response => {
            commit('SELLERDETAIL_OK', response.data.seller_detail)
            resolve()
          })
        .catch(error => {
          commit('SELLERDETAIL_FAIL')
          reject(error.response.data)
        })
    })
  },
}

const mutations = {

  SELLER_OK (state, sellers) {
    state.sellers = sellers
  },

  SELLERDETAIL_OK (state, sellerDetail) {
    state.seller_detail = sellerDetail
  },

}

export default {
  state,
  actions,
  mutations
}
