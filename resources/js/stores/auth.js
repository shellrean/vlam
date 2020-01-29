import $axios from '../api.js'

const state = () => ({

})

const mutations = {

}

const actions = {
	submit({ commit }, payload) {
		localStorage.setItem('token',null)

		commit('SET_TOKEN',null,{ root: true } )
		return new Promise((resolve, reject) => {
			$axios.post('/logedin', payload)
			.then((response) => {
				if (response.data.status == 'success') {
					localStorage.setItem('token',response.data.data.api_token)
					commit('SET_TOKEN',response.data.data, { root: true })
					commit('SET_LOADING',false, { root: true })
				}
				else if(response.data.status == 'loggedin') {
					commit('SET_ERRORS', { invalid: 'User sedang login, minta administrator untuk mereset' }, { root: true })
					commit('SET_LOADING', false, { root: true })
				}
				else if(response.data.status == 'non-sesi') {
					commit('SET_ERRORS', { invalid: 'Ujian tidak sesuai sesi' }, { root: true })
					commit('SET_LOADING', false, { root: true })
				}
				else {
					commit('SET_ERRORS', { invalid: 'No ujian/Password salah' } , { root: true })
					commit('SET_LOADING',false, { root: true })
				}
				resolve(response.data)
			})
			.catch((error) => {
				if (error.response.status == 422) {
					commit('SET_ERRORS',error.response.data.errors, { root: true})
					commit('SET_LOADING',false, { root: true })
				}
			})
		})
	},
	logoutPeserta({ commit }, payload) {
		return new Promise((resolve, reject) => {
			$axios.post('/logout') 
			.then((response) => {
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