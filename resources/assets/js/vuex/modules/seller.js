import axios from 'axios'
import * as Config from '../../config'

const state = {
  sellers: {},
  seller_detail: {},
  sellers_list: {},
  sellers_number: {},
}
const getters = {
  countSellers: state => {
    return state.sellers_number
  }
}
const actions = {
  sellersList ({commit, dispatch}) {
    commit('SELLERS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'sellers')
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

  getSellerDetail ({commit, dispatch}, id) {
    commit('SELLERDETAIL')

    return new Promise((resolve, reject) => {
      axios.post(Config.apiPath + 'seller/detail', id)
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

  loadSellerNumber ({commit, dispatch}) {
    commit('LOAD_SELLERS_NUMBER')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'loadsellersnumber')
        .then(
          response => {
            commit('LOAD_SELLERS_NUMBER_OK', response.data.sellers)
            resolve()
          })
        .catch(error => {
          commit('LOAD_SELLERS_NUMBER_FAIL')
          reject(error.response.data)
        })
    })
  },

}

const mutations = {
  SELLERS_OK (state, seller) {
    state.sellers = seller
    // state.loading = false
  },

  SELLERDETAIL_OK (state, sellerDetail) {
    state.seller_detail = sellerDetail
  },

  LOAD_SELLERS_OK (state, sellerList) {
    state.sellers_list = sellerList
  },

  LOAD_SELLERS_NUMBER_OK (state, sellersNumber) {
    state.sellers_number = sellersNumber
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
