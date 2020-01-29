import $axios from '../api.js'

const state = () => ({
	banksoalHariIni: [],
	banksoalAktif: '',
	matpelAktif: ''
})

const mutations = {
	UJIAN_HARI_INI(state, payload) {
		state.banksoalHariIni = payload
	},
	ASSIGN_UJIAN_AKTIF(state, payload) {
		state.banksoalAktif = payload
	},
	ASSIGN_MATPEL_AKTIF(state, payload) {
		state.matpelAktif = payload
	}
}

const actions = {
	ujianHariIni({ commit }) {
		return new Promise(( resolve, reject) => {
			$axios.get(`/jadwal/getday`)
			.then( (response) => {
				commit('UJIAN_HARI_INI',response.data.data)
				resolve(response.data)
			}) 
		})
	},
	ujianAktif({ commit, state }, payload) {
		return new Promise(( resolve, reject) => {
			$axios.get(`/jadwal/aktif`, payload)
			.then((response) => {
				commit('ASSIGN_UJIAN_AKTIF', response.data)
				commit('ASSIGN_MATPEL_AKTIF', response.data.matpel)
				resolve(response)
			})
		})
	}
}

export default {
	namespaced: true,
	state, 
	actions,
	mutations
}