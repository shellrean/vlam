<template>
	<div>
		<notifications group="foo" />
		<app-sidebar v-if="isAuth" />

		<div class="c-wrapper">
			<app-header v-if="isAuth" />
			
			<router-view></router-view>

			<app-footer v-if="isAuth" />

		</div >

	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex'
	import Sidebar from './components/Sidebar.vue'
	import Header from './components/Header.vue'
	import Footer from './components/Footer.vue'

	export default {
		computed: {
			...mapState(['token']),
			...mapGetters(['isAuth'])
		},
		components: {
			'app-sidebar': Sidebar,
			'app-footer' : Footer,
			'app-header' : Header,
		}
	}
</script>