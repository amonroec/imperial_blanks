import store from '~/store'

export default (to, from, next) => {
	if (store.getters['auth/user']) {
	  if (store.getters['auth/user'].admin !== 1 && store.getters['auth/user'].admin !== 2) {
	    next({ name: 'home' })
	  } else {
	    next()
	  }
	} else {
		next({ name: 'home' })
	}
}
