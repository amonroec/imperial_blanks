import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
  	next({ name: 'login' })
  } else if (!store.state.auth.user.confirmed) {
    next({ name: 'not_confirmed' })
  } else {
    next()
  }
}
