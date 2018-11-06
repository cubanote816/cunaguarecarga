import Vue from 'vue'
import Vuex from 'vuex'
import createLogger from 'vuex/dist/logger'
import auth from './modules/auth'
import toast from './modules/toast'
import users from './modules/users'
import general from './modules/general'
import order from './modules/order'
import seller from './modules/seller'
import contract from './modules/contract'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  strict: debug,
  plugins: debug ? [createLogger()] : [],
  modules: {
    auth,
    toast,
    users,
    general,
    order,
    seller,
    contract,
  }
})
