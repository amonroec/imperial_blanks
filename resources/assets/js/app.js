window.axios = require('axios');
import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)


import '~/plugins'
import '~/components'

import axios from 'axios'
import VueAxios from 'vue-axios'
import Spinner from './components/spinner'
import InnerCard from './components/inner_card'
Vue.component('spinner', Spinner);
Vue.component('inner-card', InnerCard);
// Vue.component('dropzone', Dropzone);

Vue.use(VueAxios, axios)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
