import axios from 'axios'
import * as Config from '../../config'

const state = {
  contracts: {},
  contractor: {},
  agreement: {},
}

const actions = {
  getContracts ({commit, dispatch}) {
    commit('CONTRACTS')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'contracts')
        .then(
          response => {
            commit('CONTRACTS_OK', response.data.contracts)
            resolve()
          })
        .catch(error => {
          commit('CONTRACTS_FAIL')
          reject(error.response.data)
        })
    })
  },

  getContractor ({commit, dispatch}) {
    commit('CONTRACTOR')

    return new Promise((resolve, reject) => {
      axios.get(Config.apiPath + 'contractor')
        .then(
          response => {
            commit('CONTRACTOR_OK', response.data.contractor)
            resolve()
          })
        .catch(error => {
          commit('CONTRACTOR_FAIL')
          reject(error.response.data)
        })
    })
  },

  updateAgreement ({commit, dispatch}, id) {
    commit('AGREEMENT')

    return new Promise((resolve, reject) => {
      axios.post(Config.apiPath + 'contract/agreement', id)
        .then(
          response => {
            commit('AGREEMENT_OK', response.data.user)
            resolve()
          })
        .catch(error => {
          commit('AGREEMENT_FAIL')
          reject(error.response.data)
        })
    })
  },
}

const mutations = {
  CONTRACTS_OK (state, contracts) {
    state.contracts = contracts
  },

  CONTRACTOR_OK (state, contractor) {
    state.contractor = contractor
  },

  AGREEMENT_OK (state, agreement) {
    state.agreement = agreement
  },

}

export default {
  state,
  actions,
  mutations
}
