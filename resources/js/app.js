import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './App.vue'

import CoreuiVue from '@coreui/vue'

Vue.config.performance = true
Vue.use(CoreuiVue)

new Vue({
	el: '#app',
	router,
	store,
	components: {
		App
	}
})