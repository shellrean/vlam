<template>
	<div>
		<div class="row">
		  <div class="col-md-8">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Penting untuk diingat </h4>
		        </div>
		        <div class="card-body rounded-0">
		          <h6 class="text-danger"><i class="cui-info"></i> &nbsp; No system is safe</h6>
		          <p class="text-muted">
		          	Kita hidup di dunia yang pentuh dengan masalah, jangan sampai menyontek termasuk masalah anda
		          </p>
		        </div> 
		        <div class="card-footer">
		        	
		        </div>
		      </div>
		    </div>
		  </div>
		  <div class="col-md-4">
		  	<div class="card mt-5 rounded-0">
		  		<div class="card-body">
				  	<div class="alert alert-warning rounded-0">
				    	<i class="cui-info"></i>  
				    	Anda masih bisa kembali ke tempat ini selama belum memasuki ruang ujian.
				    </div>
				    <button class="btn btn-block btn-danger rounded-0">Mulai</button>
				</div>
			</div>
		  </div>
		</div>
	</div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
	name: 'PrepareUjian',
	created() {
		this.ujianHariIni()
	},
	data() {
		return {
			disable: false
		}
	},
	computed: {
		...mapState('jadwal', {
			jadwal: state => state.banksoalHariIni,
			mulai: state => state.banksoalHariIni.mulai
		})
	},
	methods: {
	    ...mapActions('jadwal',['ujianHariIni'])
	}
}
</script>