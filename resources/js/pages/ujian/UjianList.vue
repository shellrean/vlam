<template>
	<div class="row">
	  <div class="col-md-8">
	  	<div class="card mt-5 rounded-0">
	  		<div class="card-header rounded-0">
	  			<h4>Mata ujian list</h4>
	  		</div>
	  		<div class="card-body rounded-0">
	  			<b-table outlined :items="mataujians.data" :fields="fields" show-empty>
	  				<template v-slot:cell(actions)="row">
	  					<router-link :to="{ name: 'ujian.konfirm', params: {id: row.item.id} }" class="btn btn-success rounded-0" :disabled="row.item.status == 0"><i class="cui-fullscreen-exit"></i> &nbsp; Ikuti</router-link>
	  				</template>
	  				<template v-slot:cell(statuse)="row">
	  					{{ (row.item.status == 0 ? 'Tutup' : 'Berlangsung') }}
	  				</template>
	  			</b-table>
	  		</div>
	  		<div class="card-footer"></div>
	  	</div>
	  </div>
	  <div class="col-md-4">
		<div class="card mt-5 rounded-0">
		   <div class="card-body rounded-0">
				<div id="myerror" class="alert alert-info rounded-0">
		      		<i class="cui-info"></i>  
		      		<font size="3px">Anda masih bisa kembali ke tempat ini selama belum memasuki ruang ujian.</font>
		      	</div>
			</div>
		</div>
	  </div>
      </div>
	</div>
</template>
<script>
	import { mapActions, mapState } from 'vuex'
	export default {
		name: 'UjianList',
		created() {
			this.getUjianList()
		},
	    data() {
	      return {
	      	fields: [
	      		{ key: 'banksoal.kode_banksoal', label : 'Kode' },
	      		{ key: 'mulai', label: 'Waktu'},
	      		{ key: 'statuse', label: 'Status'},
	      		{ key: 'actions', label: 'Aksi'}
	      		
	      	]
	      }
	    },
	    computed: {
	    	...mapState('ujian', {
	    		mataujians: state => state.ujianList
	    	})
	    },
	    methods: {
	    	...mapActions('ujian',['getUjianList'])
	    }
	}
</script>