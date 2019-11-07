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
			$axios.post('/login', payload)
			.then((response) => {
				if (response.data.state == 'success') {
					localStorage.setItem('token',response.data.data)
					commit('SET_TOKEN',response.data.data, { root: true })
				}
				else {
					commit('SET_ERRORS', { invalid: 'Email/Password salah' } , { root: ture})
				}
				resolve(response.data)
			})
			.catch((error) => {
				if (error.response.status == 422) {
					commit('SET_ERRORS',error.response.data.errors, { root: true})
				}
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