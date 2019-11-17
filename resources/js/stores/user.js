import $axios from '../api.js'

const state = () => ({
	pesertaDetail: []
})

const mutations = {
	ASSIGN_PESERTA_DETAIL(state, payload) {
		state.pesertaDetail = payload
	}
}

const actions = {
	setPesertaDetail({ commit , payload}) {
		return new Promise((resolve, reject) => {
			const data = {
				id: localStorage.getItem('id'),
				nama: localStorage.getItem('nama'),
				no_ujian: localStorage.getItem('no_ujian')
			}
			commit('ASSIGN_PESERTA_DETAIL',data)
		})
	}
}

export default {
	namespaced: true,
	state, 
	actions,
	mutations
}