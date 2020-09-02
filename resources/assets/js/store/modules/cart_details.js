import * as types from '../mutation-types'

// state
export const state = {
  cart: '0'
}

// getters
export const getters = {
  cart: state => state.cart
}

// mutations
export const mutations = {
  SET_CART (state) {
    if (window.localStorage.getItem('cart')) {
      state.cart = JSON.parse(window.localStorage.getItem('cart'))
    } else {
      state.cart = []
    }
  }
}

// actions
export const actions = {
  async setCart ({ commit }, obj) {
    commit('SET_CART')
  }
}
