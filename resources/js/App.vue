<template>
	<div>
		<app-sidebar v-if="isAuth" />

		<router-view></router-view>

		<app-footer v-if="isAuth" />
	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex'
	import Sidebar from './components/Sidebar.vue'
	import Footer from './components/Footer.vue'
	export default {
		computed: {
			...mapState(['token']),
			...mapGetters(['isAuth'])
		},
		components: {
			'app-sidebar': Sidebar,
			'app-footer' : Footer
		}
	}
</script>