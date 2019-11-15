import Vue from 'vue'
import Vuex from 'vuex'

import auth from './stores/auth.js'
import user from './stores/user.js'
import reference from './stores/reference.js'
import banksoal from './stores/banksoal.js'
import soal from './stores/soal.js'

Vue.use(Vuex)

const store = new Vuex.Store({
	modules: {
		auth,
		user,
		reference,
		banksoal,
		soal
	},
	state: {
		token: localStorage.getItem('token'),
		errors: []
	},
	getters: {
		isAuth: state => {
			return state.token != "null" && state.token != null
		}
	},
	mutations: {
		SET_TOKEN(state, payload) {
			state.token = payload
		},
		SET_ERRORS(state, payload) {
			state.errors = payload
		},
		CLEAR_ERRORS(state) {
			state.errors = []
		}
	}
})

export default store