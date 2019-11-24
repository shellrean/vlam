import $axios from '../api.js'

const state = () => ({
	banksoalHariIni: [],
})

const mutations = {
	UJIAN_HARI_INI(state, payload) {
		state.banksoalHariIni = payload
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
	}
}

export default {
	namespaced: true,
	state, 
	actions,
	mutations
}