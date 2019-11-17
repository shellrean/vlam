import $axios from '../api.js'

const state = () => ({
	jawabanPeserta: [],
	ujianList: [],
	filledUjian: [],
	dataUjian: ''
})

const mutations = {
	ASSIGN_DATA_JAWABAN(state, payload) {
		state.jawabanPeserta = payload
	},
	ASSIGN_DATA_LIST(state, payload) {
		state.ujianList = payload
	},
	FILLED_DATA_UJIAN(state, payload) {
		state.filledUjian = payload
	},
	SLICE_DATA_RESP(state, payload) {
		state.filledUjian.data[payload.index].jawab = payload.data.jawab
	},
	ASSIGN_DATA_UJIAN(state, payload) {
		state.dataUjian = payload
	}
}

const actions = {
	submitJawaban({ commit, state }, payload) {
		return new Promise(( resolve, reject ) => {
			$axios.post(`/ujian`, payload) 
			.then((response) => {
				commit('SLICE_DATA_RESP', response.data)
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
			$axios.post(`/ujian/daftar`)
			.then((response) => {
				commit('ASSIGN_DATA_LIST', response.data)
				resolve(response.data)
			})
		})
	},
	takeFilled({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.post(`/ujian/filled`, payload)
			.then((response) => {
				commit('FILLED_DATA_UJIAN', response.data)
			})
			.catch((error) => {

			})
		})
	},
	updateWaktuSiswa({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.post(`/ujian/sisa-waktu`, payload)
			.then((response) => {
				resolve(response.data)
			})
			.catch((error) => {

			})
		})
	}, 
	getPesertaDataUjian({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.post(`/ujian/ujian-siswa-det`, payload) 
			.then((response) => {
				commit('ASSIGN_DATA_UJIAN', response.data)
				resolve(response.data)
			})
			.catch((error) => {

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