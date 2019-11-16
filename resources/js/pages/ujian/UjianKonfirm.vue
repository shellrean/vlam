<template>
	<div>
		<div class="row">
		  <div class="col-md-6">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Konfirmasi data peserta </h4>
		        </div>
		        <div class="card-body rounded-0">
		          <table class="table table-borderless">
		          	<tr>
		          		<td width="200px">No ujian</td>
		          		<td v-text="peserta.no_ujian"></td>
		          	</tr>
		          	<tr>
		          		<td>Mata pelajaran</td>
		          		<td v-if="jadwal.banksoal" v-text="jadwal.banksoal.matpel.nama"></td>
		          	</tr>
		          	<tr>
		          		<td>Status ujian</td>
		          		<td v-text="jadwal.status_ujian"></td>
		          	</tr>
		          	<tr>
		          		<td>Waktu test dibuka</td>
		          		<td v-text="jadwal.mulai"></td>
		          	</tr>
		          	<tr>
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
	        peserta: {
	          nama: '',
	          no_ujian: ''
	        },
	        token_ujian : '',
	        invalidToken: false
	      } 
	    },
	    computed: {
	    	...mapState('jadwal', {
	    		jadwal: state => state.banksoalHariIni
	    	})
	    },
	    methods: {
	      ...mapActions('jadwal',['ujianHariIni']),
	      getDataPeserta() {
	        this.peserta.nama = localStorage.getItem('nama'),
	        this.peserta.no_ujian = localStorage.getItem('no_ujian')
	      },
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
	    },
	    mounted() {
	      this.getDataPeserta()
	    }
	}
</script>