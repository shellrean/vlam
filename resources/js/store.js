import Vue from 'vue'
import Vuex from 'vuex'

import auth from './stores/auth.js'
import user from './stores/user.js'
import reference from './stores/reference.js'
import banksoal from './stores/banksoal.js'
import soal from './stores/soal.js'
import ujian from './stores/ujian.js'

Vue.use(Vuex)

const store = new Vuex.Store({
	modules: {
		auth,
		user,
		reference,
		banksoal,
		soal,
		ujian
	},
	state: {
		token: localStorage.getItem('token'),
		role: localStorage.getItem('role'),
		errors: []
	},
	getters: {
		isAuth: state => {
			return state.token != "null" && state.token != null
		},
		isAdmin: state => {
			return state.role != "null" && state.role != null && state.role != 5
		}
	},
	mutations: {
		SET_TOKEN(state, payload) {
			state.token = payload
		},
		SET_ROLE(state, payload) {
			state.role = payload
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