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
		          	<tr v-if="jadwal.banksoal">
		          		<td>Mata pelajaran</td>
		          		<td v-text="jadwal.banksoal.matpel.nama"></td>
		          	</tr>
		          	<tr v-if="ujian.status_ujian == 0">
		          		<td>Token</td>
		          		<td v-if="jadwal.token">
		          			<div class="input-group mb-3">
							  <input type="text" class="form-control rounded-0" placeholder="Masukkan token" v-model="token_ujian" @keyup="resInv">
							  <div class="input-group-append">
							    <button class="btn btn-outline-primary rounded-0" type="button" @click="cekToken">Submit</button>
							  </div>
							</div>
							<small class="text-danger" v-if="invalidToken">Token tidak sesuai dengan pusat</small>
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
			this.ujianHariIni()
		},
	    data() {
	      return {
	        token_ujian : '',
	        invalidToken: false
	      } 
	    },
	    computed: {
	    	...mapState('jadwal', {
	    		jadwal: state => state.banksoalHariIni
	    	}),
	    	...mapState('user', {
		        peserta: state => state.pesertaDetail
		     }),
	    	...mapState('ujian', {
	    		ujian: state => state.dataUjian.data
	    	})
	    },
	    methods: {
	      ...mapActions('jadwal',['ujianHariIni']),
	      ...mapActions('ujian',['getPesertaDataUjian']),
	      cekToken(){
	      	if (this.jadwal.token != this.token_ujian) {
	      		this.invalidToken = true
	      		return
	      	}

	      	this.$router.push({ name: 'ujian.prepare' })
	      },
	      dataUjianPeserta() {
	      	this.getPesertaDataUjian({
	      		jadwal_id 	:this.jadwal.id,
	      		peserta_id 	: this.peserta.id,
	   			lama		: this.jadwal.lama
	      	})
	      },
	      resInv() {
	      	this.invalidToken = false
	      }
	    },
	    watch: {
	    	jadwal(val) {
	    		if(val.banksoal_id) {
	    			this.dataUjianPeserta()
	    		}
	    	}
	    }
	}
</script>