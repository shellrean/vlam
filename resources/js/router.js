import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import store from './store.js'

import LoginUjian from './pages/ujian/LoginUjian.vue'
import IndexUjian from './pages/ujian/Index.vue'
import UjianKonfirm from './pages/ujian/UjianKonfirm.vue'
import UjianPrepare from './pages/ujian/UjianPrepare.vue'
import Kerjakan from './pages/ujian/Kerjakan.vue'
import UjianSelesai from './pages/ujian/UjianSelesai'


Vue.use(Router)

const router = new Router({
	mode: 'history',
	routes: [
		{
			path: '/login',
			name: 'login',
			component: LoginUjian,
		},
		{
			path: '/ujian',
			component: IndexUjian,
			meta: { requiresAuth: true },
			children: [
				{
					path: 'konfirm',
					name: 'ujian.konfirm',
					component: UjianKonfirm
				},
				{
					path: 'prepare',
					name: 'ujian.prepare',
					component: UjianPrepare
				},
				{
					path: 'while/:banksoal/:jadwal_id',
					name: 'ujian.while',
					component: Kerjakan
				},
				{
					path: 'selesai',
					name: 'ujian.selesai',
					component: UjianSelesai
				}
			]
		}
	]
})

router.beforeEach((to, from , next) => {
	store.commit('CLEAR_ERRORS')
	if (to.matched.some(record => record.meta.requiresAuth)) {
		let auth = store.getters.isAuth
		if (!auth) {
			next({ name: 'login' })
		}
		else {
			next()
		}
	}
	else {
		next()
	}
})

export default router