import axios from 'axios'
import * as Config from '../../config'

const state = {
  sellers: {
    current_page: 1,
    data: [],
  },
  seller_detail: {
    current_page: 1,
    data: [],
  },
  sellers_list: {},
}

const actions = {
  sellersList ({commit, dispatch}, params) {
    commit('SELLERS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'sellers', {params})
        .then(
          response => {
            commit('SELLERS_OK', response.data.sellers)
            resolve()
          })
        .catch(error => {
          commit('SELLERS_FAIL')
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
            commit('SELLERDETAIL_OK', response.data)
            resolve()
          })
        .catch(error => {
          commit('SELLERDETAIL_FAIL')
          reject(error.response.data)
        })
    })
  },

  loadSeller ({commit, dispatch}) {
    commit('LOAD_SELLERS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'loadsellers')
        .then(
          response => {
            commit('LOAD_SELLERS_OK', response.data.sellers)
            resolve()
          })
        .catch(error => {
          commit('LOAD_SELLERS_FAIL')
          reject(error.response.data)
        })
    })
  },

}

const mutations = {
  SELLERS_OK (state, seller) {
    state.sellers = seller
  },

  SELLERDETAIL_OK (state, sellerDetail) {
    state.seller_detail = sellerDetail
  },

  LOAD_SELLERS_OK (state, sellerList) {
    state.sellers_list = sellerList
  },
}

export default {
  state,
  actions,
  mutations
}
