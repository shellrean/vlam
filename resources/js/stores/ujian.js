import $axios from '../api.js'

const state = () => ({
	jawabanPeserta: [],
	ujianList: []
})

const mutations = {
	ASSIGN_DATA_JAWABAN(state, payload) {
		state.jawabanPeserta = payload
	},
	ASSIGN_DATA_LIST(state, payload) {
		state.ujianList = payload
	}
}

const actions = {
	submitJawaban({ commit, state }, payload) {
		return new Promise(( resolve, reject ) => {
			$axios.post(`/ujian`, payload) 
			.then((response) => {
				resolve(response.data)
			})
			.catch((error) => {
				if (error.response.status == 422) {
					commit('SET_ERRORS', error.response.data.errors, { root: true })
				}
			})
		})
	},
	getJawabanPeserta({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.get(`/ujian/jawaban/${payload}`)
			.then((response) => {
				commit('ASSIGN_DATA_JAWABAN', response.data)
				resolve(response.data)
			})
		})
	},
	getUjianList({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.get(`/ujian/list`)
			.then((response) => {
				commit('ASSIGN_DATA_LIST', response.data)
				resolve(response.data)
			})
		})
	}
}

export default {
	namespaced: true,
	state,
	mutations,
	actions
}