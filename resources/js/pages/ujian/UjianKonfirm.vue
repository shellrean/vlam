<template>
	<div class="container">
		<div class="row justify-content-md-center">
		  <div class="col-md-8">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Konfirmasi data peserta </h4>
		        </div>
		        <div class="card-body rounded-0 fade-in" v-if="jadwal && ujian">
		          <table class="table table-borderless">
		          	<tr>
		          		<td width="200px">No ujian</td>
		          		<td v-text="peserta.no_ujian"></td>
		          	</tr>
		          	<tr>
		          		<td>Nama peserta</td>
		          		<td v-text="peserta.nama"></td>
		          	</tr>
		          	<tr v-if="jadwal.banksoal">
		          		<td>Mata pelajaran</td>
		          		<td v-text="jadwal.banksoal.matpel.nama"></td>
		          	</tr>
		          	<tr v-if="ujian.status_ujian != 1">
		          		<td>Token</td>
		          		<td>
		          			<div class="input-group mb-3">
							  <input type="text" class="form-control rounded-0" placeholder="Masukkan token" v-model="token_ujian">
							  <div class="input-group-append">
							    <button class="btn btn-outline-primary rounded-0" type="button" @click="cekToken">Submit</button>
							  </div>
							</div>
							<small class="text-danger" v-if="invalidToken.token">Token tidak sesuai dengan pusat</small>
							<small class="text-danger" v-if="invalidToken.release">Status token belum dirilis</small>
						</td>
		          	</tr>
		          </table>
		        </div> 
		        <div class="card-body rounded-0 fade-in" v-if="!ujian">
		        	<div class="alert alert-info rounded-0"><i class="cui-info"></i> &nbsp; Tidak ada jadwal ujian pada hari ini</div>
			          <table class="table table-borderless">
			          	<tr>
			          		<td width="200px">No ujian</td>
			          		<td v-text="peserta.no_ujian"></td>
			          	</tr>
			          </table>
			        </div>
		        </div>
		        <div class="card-footer">
		        	
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
		name: 'KonfirmUjian',
		created() {
			this.ujianAktif()
		},
	    data() {
	      return {
	        token_ujian : '',
	        timeout: 0
	      } 
	    },
	    computed: {
	    	...mapState('jadwal', {
	    		jadwal: state => state.banksoalAktif.data,
	    	}),
	    	...mapState('user', {
		        peserta: state => state.pesertaDetail
		     }),
	    	...mapState('ujian', {
	    		ujian: state => state.dataUjian.data,
	    		invalidToken: state => state.invalidToken
	    	})
	    },
	    methods: {
	      ...mapActions('jadwal',['ujianAktif']),
	      ...mapActions('ujian',['getPesertaDataUjian','tokenChecker']),
	      cekToken(){
	      	this.tokenChecker({
	      		token: this.token_ujian
	      	})
	      	.then(() => {
	      		this.$router.push({ name: 'ujian.prepare' })
	      	})
	      	.catch(() => {
	      		
	      	})
	      },
	      dataUjianPeserta() {
	      	this.getPesertaDataUjian({
	      		jadwal_id 	:this.jadwal.jadwal.id,
	      		peserta_id 	: this.peserta.id,
	   			lama		: this.jadwal.jadwal.lama
	      	})
	      }
	    },
	    watch: {
	    	jadwal(val) {
	    		if(typeof(val) != 'undefined') {
	    			this.dataUjianPeserta()
	    		}
	    	}
	    }
	}
</script>