import store from '~/store'

export default (to, from, next) => {
	if (store.getters['auth/user']) {
	  if (store.getters['auth/user'].company_admin !== 1) {
	    next({ name: 'home' })
	  } else {
	    next()
	  }
	} else {
		next({ name: 'home' })
	}
}
