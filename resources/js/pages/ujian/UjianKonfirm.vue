<template>
	<div class="container">
		<div class="row justify-content-md-center">
		  <div class="col-md-6">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Konfirmasi data peserta </h4>
		        </div>
		        <div class="card-body rounded-0">
		          <div class="alert alert-danger rounded-0" v-if="!jadwal.mulai"><i class="cui-info"></i> &nbsp; Tidak ada jadwal ujian pada hari ini</div>
		          <table class="table table-borderless">
		          	<tr>
		          		<td width="200px">No ujian</td>
		          		<td v-text="peserta.no_ujian"></td>
		          	</tr>
		          	<tr v-if="jadwal.banksoal">
		          		<td>Mata pelajaran</td>
		          		<td v-text="jadwal.banksoal.matpel.nama"></td>
		          	</tr>
		          	<tr v-if="jadwal.mulai">
		          		<td>Waktu test dibuka</td>
		          		<td v-text="jadwal.mulai"></td>
		          	</tr>
		          	<tr v-if="jadwal.token">
		          		<td>Token</td>
		          		<td>
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
		     })
	    },
	    methods: {
	      ...mapActions('jadwal',['ujianHariIni']),
	      cekToken(){
	      	if (this.jadwal.token != this.token_ujian) {
	      		this.invalidToken = true
	      		return
	      	}

	      	this.$router.push({ name: 'ujian.prepare' })
	      },
	      resInv() {
	      	this.invalidToken = false
	      }
	    }
	}
</script>