<template>
	<div class="row">
	  <div class="col-md-8">
	  	<div class="card mt-5">
	  		<div class="card-header">
	  			<h4>Mata ujian list</h4>
	  		</div>
	  		<div class="card-body">
	  			<b-table :items="items" :fields="fields" outlined></b-table>
	  		</div>
	  	</div>
	  </div>
	</div>
</template>
<script>
	import { mapState, mapActions } from 'vuex'
	export default {
		name: 'UjianList',
		created() {
			this.getUjianList()
		},
	    data() {
	      return {
	        fields: [
	        	{ key: 'waktu', label: 'Waktu' },
	        	{ key: 'mapel', label: 'Mata pelajaran' },
	        	{ key: 'status', label: 'Status' }
	        ]
	      }
	    },
	    computed: {
	    	...mapState('ujian', {
	    		mataujians: state => state.mataujians
	    	})
	    },
	    methods: {
	    	...mapActions('ujian',['getUjianList'])
	    }
	}
</script>